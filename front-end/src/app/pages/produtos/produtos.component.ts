import { AfterViewInit, Component, OnInit, ViewChild } from '@angular/core';
import { MatPaginator, MatPaginatorModule } from '@angular/material/paginator';
import { MatTableDataSource, MatTableModule } from '@angular/material/table';
import { MatButtonModule } from '@angular/material/button';
import { MatIconModule } from '@angular/material/icon';
import { MatSnackBar } from '@angular/material/snack-bar';

import { Router, RouterLink } from '@angular/router';

import { ProdutosService } from '../../services/produtos/produtos.service';
import { Produto } from '../../models/Produto';

@Component({
  selector: 'app-produtos',
  standalone: true,
  imports: [
    MatTableModule,
    MatPaginatorModule,
    MatButtonModule,
    MatIconModule,
    RouterLink,
  ],
  templateUrl: './produtos.component.html',
  styleUrl: './produtos.component.scss',
})
export class ProdutosComponent implements AfterViewInit, OnInit {
  constructor(
    private produtosService: ProdutosService,
    private _snackBar: MatSnackBar,
    private router: Router
  ) {}

  displayedColumns: string[] = [
    'id',
    'nome',
    'codigo',
    'valor',
    'quantidade',
    'actions',
  ];

  dataSource!: MatTableDataSource<Produto>;

  @ViewChild(MatPaginator) paginator!: MatPaginator;

  ngAfterViewInit() {
    this.dataSource.paginator = this.paginator;
  }

  ngOnInit(): void {
    this.getProdutos();
  }

  getProdutos() {
    this.produtosService.getAllProdutos().subscribe(
      (resp) => {
        this.dataSource = new MatTableDataSource<Produto>(resp);
      },
      (error) => {
        console.log(error);
      }
    );
  }

  delete(produto: Produto) {
    this.produtosService.delete(produto.id).subscribe(
      (resp: any) => {
        if (resp.status == 200) {
          this.openSnackBar(resp.message);
          this.getProdutos();
        }
      },
      (resp) => {
        const errorMessage: string =
          resp.error?.message || 'Erro ao deletar o produto';
        this.openSnackBar(errorMessage);
      }
    );
  }

  edit(produto: Produto) {
    this.router.navigate(['/editar-produto'], { queryParams: produto });
  }

  openSnackBar(message: string) {
    this._snackBar.open(message, 'Ok', {
      duration: 3000,
    });
  }
}
