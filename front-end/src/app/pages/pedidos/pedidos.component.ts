import { AfterViewInit, Component, OnInit, ViewChild } from '@angular/core';
import { MatPaginator, MatPaginatorModule } from '@angular/material/paginator';
import { MatTableDataSource, MatTableModule } from '@angular/material/table';
import { PedidosService } from '../../services/pedidos/pedidos.service';

@Component({
  selector: 'app-pedidos',
  standalone: true,
  imports: [MatPaginatorModule, MatTableModule],
  templateUrl: './pedidos.component.html',
  styleUrl: './pedidos.component.scss',
})
export class PedidosComponent implements AfterViewInit, OnInit {
  constructor(private pedidosService: PedidosService) {}

  displayedColumns: string[] = [
    'id',
    'produto',
    'quantidade',
    'cliente',
    'data',
  ];

  dataSource!: MatTableDataSource<Pedido>;

  @ViewChild(MatPaginator) paginator!: MatPaginator;

  ngAfterViewInit() {
    this.dataSource.paginator = this.paginator;
  }

  ngOnInit(): void {
    this.getPedidos();
  }

  getPedidos() {
    this.pedidosService.getPedidos().subscribe((resp) => {
      this.dataSource = new MatTableDataSource<Pedido>(resp.data);
    });
  }
}

export interface Pedido {
  id: number;
  id_produto: string;
  quantidade_prod_pedido: number;
  id_cliente: string;
  created_at: string;
  updated_at: string;
}
