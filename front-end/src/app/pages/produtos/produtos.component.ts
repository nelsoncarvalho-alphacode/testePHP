import { AfterViewInit, Component, OnInit, ViewChild } from '@angular/core';
import { MatPaginator, MatPaginatorModule } from '@angular/material/paginator';
import { MatTableDataSource, MatTableModule } from '@angular/material/table';
import { ProdutosService } from '../../services/produtos/produtos.service';

@Component({
  selector: 'app-produtos',
  standalone: true,
  imports: [MatTableModule, MatPaginatorModule],
  templateUrl: './produtos.component.html',
  styleUrl: './produtos.component.scss',
})
export class ProdutosComponent implements AfterViewInit, OnInit {
  constructor(private produtosService: ProdutosService) {}

  displayedColumns: string[] = ['id', 'nome', 'codigo', 'valor'];

  dataSource!: MatTableDataSource<Produto>;

  @ViewChild(MatPaginator) paginator!: MatPaginator;

  ngAfterViewInit() {
    this.dataSource.paginator = this.paginator;
  }

  ngOnInit(): void {
    this.getProdutos();
  }

  getProdutos() {
    this.produtosService.getProdutos().subscribe((resp) => {
      this.dataSource = new MatTableDataSource<Produto>(resp.data);
    });
  }
}

export interface Produto {
  id: number;
  nome: string;
  cod_barras: number;
  valor: string;
  qtd_prod: number;
  created_at: string;
  updated_at: string;
}
