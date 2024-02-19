import { AfterViewInit, Component, OnInit, ViewChild } from '@angular/core';
import { MatPaginator, MatPaginatorModule } from '@angular/material/paginator';
import { MatTableDataSource, MatTableModule } from '@angular/material/table';
import { MatIconModule } from '@angular/material/icon';
import { MatButtonModule } from '@angular/material/button';
import { Router, RouterLink } from '@angular/router';
import { MatSnackBar } from '@angular/material/snack-bar';
import { PedidosService } from '../../services/pedidos/pedidos.service';
import { Pedido } from '../../models/Pedido';

@Component({
  selector: 'app-pedidos',
  standalone: true,
  imports: [
    MatPaginatorModule,
    MatTableModule,
    MatIconModule,
    MatButtonModule,
    RouterLink,
  ],
  templateUrl: './pedidos.component.html',
  styleUrl: './pedidos.component.scss',
})
export class PedidosComponent implements AfterViewInit, OnInit {
  constructor(
    private pedidosService: PedidosService,
    private _snackBar: MatSnackBar,
    private router: Router
  ) {}

  displayedColumns: string[] = [
    'id',
    'produto',
    'quantidade',
    'cliente',
    'data-criacao',
    'data-atualizacao',
    'actions',
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
    this.pedidosService.getAllPedidos().subscribe((resp) => {
      this.dataSource = new MatTableDataSource<Pedido>(resp);
    });
  }

  edit(pedido: any) {
    this.router.navigate(['/editar-pedido'], { queryParams: pedido });
  }

  delete(pedido: any) {
    this.pedidosService.delete(pedido.id).subscribe(
      (resp: any) => {
        if (resp.status == 200) {
          this.openSnackBar(resp.message);
          this.getPedidos();
        }
      },
      (resp) => {
        const errorMessage: string =
          resp.error?.message || 'Erro ao deletar o pedido';
        this.openSnackBar(errorMessage);
      }
    );
  }

  openSnackBar(message: string) {
    this._snackBar.open(message, 'Ok', {
      duration: 3000,
    });
  }
}
