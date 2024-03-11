<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;

use App\Models\Product;
use App\Models\Categorie;

class ProductController extends Controller
{
    private function productNotFound() {
        return redirect()->route('products.index')->with('error', 'Produto não encontrado.');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 20);
        $sort = $request->input('sort', 'id');
        $direction = $request->input('direction', 'asc');

        $categories = Categorie::getCategories();

        if ($categories->isEmpty()) {
            return redirect()->route('categories.index')->with('error', 'Por favor, crie uma categoria antes de listar os produtos.');
        }

        $products = Product::getProducts($sort, $direction, $perPage, $categories->first()->id);

        return view('products.index', compact('perPage', 'sort', 'direction', 'categories', 'products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Categorie::all();
        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validação dos dados do formulário
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'quantity' => 'required|integer',
                'description' => 'nullable|string',
                'price' => 'required|numeric',
                'barcode' => 'nullable|string|max:255|unique:products,barcode',
                'status' => 'required|boolean',
                'categorie_id' => 'required|numeric|exists:categories,id',
                'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Tamanho máximo de 2MB
            ], [
                'name.required' => 'O nome do produto é obrigatório.',
                'quantity.required' => 'A quantidade do produto é obrigatória.',
                'price.required' => 'O preço do produto é obrigatório.',
                'categorie.required' => 'A categoria do produto é obrigatória.',
                'categorie.exists' => 'A categoria selecionada é inválida.',
                'image.image' => 'O arquivo enviado não é uma imagem válida.',
                'image.mimes' => 'A imagem deve ser um arquivo do tipo: jpeg, png, jpg ou gif.',
                'image.max' => 'A imagem não pode ter mais de 2MB.',
            ]);

            // Criação de um novo produto
            $product = Product::create($validatedData);

            if ($request->hasFile('image')) {
                // Gerar um nome único usando UUID
                $imagePath = Str::uuid()->toString() . '.' . $request->file('image')->getClientOriginalExtension();
                $request->file('image')->storeAs('public/images/products', $imagePath);

                // Adicione o caminho da imagem ao produto recém-criado
                $product->image_path = $imagePath;
    
                // Salvar o produto com o caminho da imagem
                $product->save();
            }

            // Redirecionamento após salvar o produto
            return redirect()->route('products.index')->with('success', 'Produto adicionado com sucesso.');
        } catch (ModelNotFoundException $e) {

            return $this->productNotFound();
        } catch (\Illuminate\Validation\ValidationException $e) {

            // Redireciona de volta ao formulário com erros de validação
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {

            return redirect()->route('products.index')->with('error', 'Erro ao adicionar produto.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $product = Product::withTrashed()->with('categorie')->find($id);

            return view('products.show', compact('product'));
        } catch (ModelNotFoundException $e) {

            return $this->productNotFound();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $categories = Categorie::all();
            $product = Product::withTrashed()->findOrFail($id);

            return view('products.edit', compact('product', 'categories'));
        } catch (ModelNotFoundException $e) {

            return $this->productNotFound();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $product = Product::withTrashed()->findOrFail($id);

            // Validação dos dados do formulário
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'quantity' => 'required|integer',
                'description' => 'nullable|string',
                'price' => 'required|numeric',
                'barcode' => 'nullable|string|max:255',
                'status' => 'required|boolean',
                'categorie_id' => 'required|numeric',
                'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Tamanho máximo de 2MB
            ], [
                'name.required' => 'O nome é obrigatório.',
                'name.string' => 'O nome deve ser uma string.',
                'name.max' => 'O nome não pode ter mais de :max caracteres.',
                'quantity.required' => 'A quantidade é obrigatória.',
                'quantity.integer' => 'A quantidade deve ser um número inteiro.',
                'description.string' => 'A descrição deve ser uma string.',
                'price.required' => 'O preço é obrigatório.',
                'price.numeric' => 'O preço deve ser um número.',
                'barcode.string' => 'O código de barras deve ser uma string.',
                'barcode.max' => 'O código de barras não pode ter mais de :max caracteres.',
                'status.required' => 'O status é obrigatório.',
                'status.boolean' => 'O status deve ser verdadeiro ou falso.',
                'categorie_id.required' => 'A categoria é obrigatória.',
                'categorie_id.numeric' => 'A categoria deve ser um número.',
                'image.image' => 'O arquivo enviado não é uma imagem válida.',
                'image.mimes' => 'A imagem deve ser um arquivo do tipo: jpeg, png, jpg ou gif.',
                'image.max' => 'A imagem não pode ter mais de 2MB.',
            ]);

            // Remover a imagem antiga se existir
            if ($product->image_path) {
                Storage::delete('public/images/products/' . $product->image_path);
            }

            if ($request->hasFile('image')) {
                // Gerar um nome único usando UUID
                $imagePath = Str::uuid()->toString() . '.' . $request->file('image')->getClientOriginalExtension();
                $request->file('image')->storeAs('public/images/products', $imagePath);
                $product->image_path = $imagePath;
            }

            // Atualizar os dados do produto
            $product->fill($validatedData)->save();

            // Redirecionamento após salvar o produto
            return redirect()->route('products.index')->with('success', 'Produto editado com sucesso.');
        } catch (ModelNotFoundException $e) {

            return $this->productNotFound();
        } catch (\Exception $e) {

            return redirect()->route('products.index')->with('error', 'Erro ao editar produto.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $product = Product::withTrashed()->findOrFail($id); // Encontra o produto pelo ID, incluindo registros deletados
            if ($product->image_path) {
                Storage::delete('public/images/products/' . $product->image_path);
            }
            $product->forceDelete(); // Força a exclusão física do produto

            return redirect()->route('products.index')->with('success', 'Produto excluído com sucesso');
        } catch (ModelNotFoundException $e) {

            return $this->productNotFound();
        } catch (\Exception $e) {

            return redirect()->route('products.index')->with('error', 'Erro ao excluir produto.');
        }
    }

    public function softDeleted(string $id)
    {
        try {
            $product = Product::find($id);
            $product->delete();
            
            return redirect()->route('products.index')->with('success', 'Produto deletado com sucesso');
        } catch (ModelNotFoundException $e) {

            return $this->productNotFound();
        } catch (\Exception $e) {

            return redirect()->route('products.index')->with('error', 'Erro ao deletar produto.');
        }
    }

    public function showDeleted(Request $request)
    {
        try {
            $perPage = $request->input('per_page', 20);
            $sort = $request->input('sort', 'id');
            $direction = $request->input('direction', 'asc');

            $categories = Categorie::getCategories(true); // Obtém todas as categorias com produtos deletados

            // Se houver categorias com produtos deletados, carrega os produtos deletados da primeira categoria
            if ($categories->isNotEmpty()) {
                $products = Product::getProductsDeleted($sort, $direction, $perPage, $categories->first()->id);

                return view('products.showDeleted', compact('perPage', 'sort', 'direction', 'categories', 'products'));
            }
            
            // Se não houver categorias com produtos deletados, retorna uma view vazia ou uma mensagem informando
            return redirect()->route('products.index')->with('error', 'Sem produtos deletados.');
        } catch (ModelNotFoundException $e) {

            return $this->productNotFound();
        }
    }

    public function restore(string $id)
    {
        try {
            $product = Product::withTrashed()->find($id);
            $product->restore();

            return redirect()->route('products.index')->with('success', 'Produto restaurado com sucesso');
        } catch (ModelNotFoundException $e) {

            return $this->productNotFound();
        } catch (\Exception $e) {

            return redirect()->route('products.index')->with('error', 'Erro ao restaurar produto.');
        }
    }

    public function filterProducts(Request $request)
    {
        try {
            $query = Product::where('categorie_id', $request->categorieId);
            
            if ($request->input('page') === "product.show_deleted") {
                $query->onlyTrashed();
            } else {
                $query->whereNull('deleted_at');
            }

            if ($request->input('page') !== "product.index") {
                $query->where('status', 1);
            }

            $products = $query->get();
            
            return response()->json($products);
        } catch (ModelNotFoundException $e) {

            return $this->productNotFound();
        } catch (\Exception $e) {

            return response()->json(['error' => 'Erro ao filtrar produtos.'], 500);
        }
    }
}
