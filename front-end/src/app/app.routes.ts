import { Routes } from '@angular/router';
import { ProdutosComponent } from './pages/produtos/produtos.component';
import { ClientesComponent } from './pages/clientes/clientes.component';
import { PedidosComponent } from './pages/pedidos/pedidos.component';
import { NovoProdutoComponent } from './pages/produtos/novo-produto/novo-produto.component';
import { EditarProdutoComponent } from './pages/produtos/editar-produto/editar-produto.component';
import { NovoClienteComponent } from './pages/clientes/novo-cliente/novo-cliente.component';
import { EditarClienteComponent } from './pages/clientes/editar-cliente/editar-cliente.component';
import { NovoPedidoComponent } from './pages/pedidos/novo-pedido/novo-pedido.component';
import { EditarPedidoComponent } from './pages/pedidos/editar-pedido/editar-pedido.component';

export const routes: Routes = [
  { path: '', component: ProdutosComponent },
  { path: 'novo-produto', component: NovoProdutoComponent },
  { path: 'editar-produto', component: EditarProdutoComponent },

  { path: 'clientes', component: ClientesComponent },
  { path: 'novo-cliente', component: NovoClienteComponent },
  { path: 'editar-cliente', component: EditarClienteComponent },

  { path: 'pedidos', component: PedidosComponent },
  { path: 'novo-pedido', component: NovoPedidoComponent },
  { path: 'editar-pedido', component: EditarPedidoComponent },
];
