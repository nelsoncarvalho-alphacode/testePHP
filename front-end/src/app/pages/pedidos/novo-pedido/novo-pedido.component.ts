import { Component, OnInit } from '@angular/core';
import { CommonModule, Location } from '@angular/common';
import { Router } from '@angular/router';
import { MatSnackBar } from '@angular/material/snack-bar';
import { MatFormFieldModule } from '@angular/material/form-field';
import { MatInputModule } from '@angular/material/input';
import { FormControl, FormsModule, ReactiveFormsModule } from '@angular/forms';
import { MatButtonModule } from '@angular/material/button';
import { Pedido } from '../../../models/Pedido';
import { PedidosService } from '../../../services/pedidos/pedidos.service';
import { MatAutocompleteModule } from '@angular/material/autocomplete';
import { AsyncPipe } from '@angular/common';
import { ProdutosService } from '../../../services/produtos/produtos.service';
import { Produto } from '../../../models/Produto';
import { Cliente } from '../../../models/Cliente';
import { ClientesService } from '../../../services/clientes/clientes.service';

@Component({
  selector: 'app-novo-pedido',
  standalone: true,
  imports: [
    CommonModule,
    MatFormFieldModule,
    MatInputModule,
    FormsModule,
    MatButtonModule,
    MatAutocompleteModule,
    AsyncPipe,
    ReactiveFormsModule,
  ],
  templateUrl: './novo-pedido.component.html',
  styleUrl: './novo-pedido.component.scss',
})
export class NovoPedidoComponent implements OnInit {
  pedido: Partial<Pedido> = {
    cliente_id: 0,
    produto_id: 0,
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
    private pedidoService: PedidosService,
    private produtoService: ProdutosService,
    private clienteService: ClientesService,
    private location: Location,
    private router: Router,
    private _snackBar: MatSnackBar
  ) {}
  ngOnInit() {
    this.getAllProdutos();
    this.getAllClientes();
    this.produto.valueChanges.subscribe((name) => this.filter(name as string));
    this.cliente.valueChanges.subscribe((name) =>
      this.filterCliente(name as string)
    );
  }

  private filter(value: string) {
    const name = value.toLowerCase();
    this.filtered_options = this.options.filter((option) =>
      option.nome.toLowerCase().includes(name)
    );
  }

  private filterCliente(value: string) {
    const name = value.toLowerCase();
    this.filtered_options_clientes = this.options_clientes.filter((option) =>
      option.nome.toLowerCase().includes(name)
    );
  }

  getAllProdutos() {
    this.produtoService.getAllProdutos().subscribe((resp) => {
      this.options = resp;
      this.filtered_options = resp;
    });
  }

  getAllClientes() {
    this.clienteService.getAllClientes().subscribe((resp) => {
      this.options_clientes = resp;
      this.filtered_options_clientes = resp;
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
      ...this.pedido,
      cliente_id: client?.id,
      produto_id: prod?.id,
    };

    this.pedidoService.save(pedido_req).subscribe(
      (resp: any) => {
        if (resp.status == 201) {
          this.router.navigate(['/pedidos']);
        }
      },
      (resp) => {
        const errorMessage: string =
          resp.error?.message || 'Erro ao cadastrar o pedido';
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
