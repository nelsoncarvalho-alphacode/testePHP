import { AfterViewInit, Component, OnInit, ViewChild } from '@angular/core';
import { MatPaginator, MatPaginatorModule } from '@angular/material/paginator';
import { MatTableDataSource, MatTableModule } from '@angular/material/table';
import { ClientesService } from '../../services/clientes/clientes.service';

@Component({
  selector: 'app-clientes',
  standalone: true,
  imports: [MatPaginatorModule, MatTableModule],
  templateUrl: './clientes.component.html',
  styleUrl: './clientes.component.scss',
})
export class ClientesComponent implements AfterViewInit, OnInit {
  constructor(private clientesService: ClientesService) {}

  displayedColumns: string[] = ['id', 'nome', 'cpf', 'email'];

  dataSource!: MatTableDataSource<Cliente>;

  @ViewChild(MatPaginator) paginator!: MatPaginator;

  ngAfterViewInit() {
    this.dataSource.paginator = this.paginator;
  }

  ngOnInit(): void {
    this.getClientes();
  }

  getClientes() {
    this.clientesService.getClientes().subscribe((resp) => {
      this.dataSource = new MatTableDataSource<Cliente>(resp.data);
    });
  }
}

export interface Cliente {
  id: number;
  nome: string;
  cpf: string;
  email: string;
}
