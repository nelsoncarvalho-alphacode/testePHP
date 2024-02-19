import { Component, OnInit } from '@angular/core';
import { Pedido } from '../../../models/Pedido';
import { ActivatedRoute, Router } from '@angular/router';
import { ProdutosService } from '../../../services/produtos/produtos.service';
import { CommonModule, Location } from '@angular/common';
import { MatSnackBar } from '@angular/material/snack-bar';
import { FormControl, FormsModule, ReactiveFormsModule } from '@angular/forms';
import { Produto } from '../../../models/Produto';
import { Cliente } from '../../../models/Cliente';
import { MatAutocompleteModule } from '@angular/material/autocomplete';
import { MatButtonModule } from '@angular/material/button';
import { MatInputModule } from '@angular/material/input';
import { MatFormFieldModule } from '@angular/material/form-field';
import { PedidosService } from '../../../services/pedidos/pedidos.service';
import { ClientesService } from '../../../services/clientes/clientes.service';

@Component({
  selector: 'app-editar-pedido',
  standalone: true,
  imports: [
    CommonModule,
    MatFormFieldModule,
    MatInputModule,
    FormsModule,
    MatButtonModule,
    MatAutocompleteModule,
    ReactiveFormsModule,
  ],
  templateUrl: './editar-pedido.component.html',
  styleUrl: './editar-pedido.component.scss',
})
export class EditarPedidoComponent implements OnInit {
  pedido: Partial<Pedido> = {
    id: 0,
    produto_id: 0,
    cliente_id: 0,
    quantidade_prod_pedido: 1,
  };

  disableBtn: boolean = false;

  produto = new FormControl('');
  cliente = new FormControl('');
  options: Produto[] = [];
  filtered_options: Produto[] = [];

  options_clientes: Cliente[] = [];
  filtered_options_clientes: Cliente[] = [];

  constructor(
    private route: ActivatedRoute,
    private pedidoService: PedidosService,
    private produtoService: ProdutosService,
    private clienteService: ClientesService,
    private location: Location,
    private router: Router,
    private _snackBar: MatSnackBar
  ) {
    this.route.queryParams.subscribe((params) => {
      this.pedido.id = params['id'];
      this.pedido.cliente_id = params['cliente_id'];
      this.pedido.produto_id = params['produto_id'];
      this.pedido.quantidade_prod_pedido = params['quantidade_prod_pedido'];
    });
  }

  ngOnInit(): void {
    this.getAllProdutos();
    this.getAllClientes();

    this.produto.valueChanges.subscribe((name) => this.filter(name as string));
    this.cliente.valueChanges.subscribe((name) =>
      this.filterCliente(name as string)
    );
  }

  private filter(value: string) {
    if (value) {
      const name = value.toLowerCase();
      this.filtered_options = this.options.filter((option) =>
        option.nome.toLowerCase().includes(name)
      );
    }
  }

  private filterCliente(value: string) {
    if (value) {
      const name = value.toLowerCase();
      this.filtered_options_clientes = this.options_clientes.filter((option) =>
        option.nome.toLowerCase().includes(name)
      );
    }
  }

  getAllProdutos() {
    this.produtoService.getAllProdutos().subscribe((resp) => {
      this.options = resp;
      this.filtered_options = resp;

      this.produto.setValue(
        this.options.find((prod) => prod.id == this.pedido.produto_id)
          ?.nome as string
      );
    });
  }

  getAllClientes() {
    this.clienteService.getAllClientes().subscribe((resp) => {
      this.options_clientes = resp;
      this.filtered_options_clientes = resp;

      this.cliente.setValue(
        this.options_clientes.find(
          (client) => client.id == this.pedido.cliente_id
        )?.nome as string
      );
    });
  }

  save() {
    this.disableBtn = true;

    const prod = this.options.find((prod) => prod.nome == this.produto.value);

    const client = this.options_clientes.find(
      (client) => client.nome == this.cliente.value
    );

    if (!prod) {
      this.openSnackBar('Produto iválido');
    }

    if (!client) {
      this.openSnackBar('Cliente iválido');
    }

    const pedido_req = {
      quantidade_prod_pedido: this.pedido.quantidade_prod_pedido as number,
      cliente_id: client?.id,
      produto_id: prod?.id,
    };

    this.pedidoService.update(pedido_req, this.pedido.id as number).subscribe(
      (resp: any) => {
        if (resp.status == 200) {
          this.router.navigate(['/pedidos']);
        }
      },
      (resp) => {
        const errorMessage: string =
          resp.error?.message || 'Erro ao atualizar o pedido';
        this.openSnackBar(errorMessage);
        this.disableBtn = false;
      }
    );
  }

  goBack() {
    this.location.back();
  }

  openSnackBar(message: string) {
    this._snackBar.open(message, 'Ok', {
      duration: 3000,
    });
  }
}
