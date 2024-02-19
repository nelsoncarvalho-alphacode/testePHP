import { AfterViewInit, Component, OnInit, ViewChild } from '@angular/core';
import { MatPaginator, MatPaginatorModule } from '@angular/material/paginator';
import { MatTableDataSource, MatTableModule } from '@angular/material/table';
import { ClientesService } from '../../services/clientes/clientes.service';
import { MatIconModule } from '@angular/material/icon';
import { MatButtonModule } from '@angular/material/button';
import { Cliente } from '../../models/Cliente';
import { Router, RouterLink } from '@angular/router';
import { MatSnackBar } from '@angular/material/snack-bar';

@Component({
  selector: 'app-clientes',
  standalone: true,
  imports: [
    MatPaginatorModule,
    MatTableModule,
    MatIconModule,
    MatButtonModule,
    RouterLink,
  ],
  templateUrl: './clientes.component.html',
  styleUrl: './clientes.component.scss',
})
export class ClientesComponent implements AfterViewInit, OnInit {
  constructor(
    private clientesService: ClientesService,
    private _snackBar: MatSnackBar,
    private router: Router
  ) {}

  displayedColumns: string[] = ['id', 'nome', 'cpf', 'email', 'actions'];

  dataSource!: MatTableDataSource<Cliente>;

  @ViewChild(MatPaginator) paginator!: MatPaginator;

  ngAfterViewInit() {
    this.dataSource.paginator = this.paginator;
  }

  ngOnInit(): void {
    this.getClientes();
  }

  getClientes() {
    this.clientesService.getAllClientes().subscribe(
      (resp) => {
        this.dataSource = new MatTableDataSource<Cliente>(resp);
      },
      (error) => {
        console.log(error);
      }
    );
  }

  edit(cliente: Cliente) {
    this.router.navigate(['/editar-cliente'], { queryParams: cliente });
  }

  delete(cliente: Cliente) {
    this.clientesService.delete(cliente.id).subscribe(
      (resp: any) => {
        if (resp.status == 200) {
          this.openSnackBar(resp.message);
          this.getClientes();
        }
      },
      (resp) => {
        const errorMessage: string =
          resp.error?.message || 'Erro ao deletar o cliente';
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
