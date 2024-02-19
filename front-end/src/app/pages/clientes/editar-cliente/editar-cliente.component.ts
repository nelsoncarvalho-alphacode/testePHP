import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { MatFormFieldModule } from '@angular/material/form-field';
import { MatInputModule } from '@angular/material/input';
import { FormsModule } from '@angular/forms';
import { MatButtonModule } from '@angular/material/button';
import { Location } from '@angular/common';
import { MatSnackBar } from '@angular/material/snack-bar';
import { ClientesService } from '../../../services/clientes/clientes.service';
import { Cliente } from '../../../models/Cliente';

@Component({
  selector: 'app-editar-cliente',
  standalone: true,
  imports: [MatFormFieldModule, MatInputModule, FormsModule, MatButtonModule],
  templateUrl: './editar-cliente.component.html',
  styleUrl: './editar-cliente.component.scss',
})
export class EditarClienteComponent {
  cliente: Partial<Cliente> = {
    id: 0,
    nome: '',
    cpf: '',
    email: '',
  };

  disableBtn: boolean = false;

  constructor(
    private route: ActivatedRoute,
    private clientesService: ClientesService,
    private location: Location,
    private router: Router,
    private _snackBar: MatSnackBar
  ) {}

  ngOnInit(): void {
    this.route.queryParams.subscribe((params) => {
      this.cliente.id = params['id'];
      this.cliente.nome = params['nome'];
      this.cliente.email = params['email'];
      this.cliente.cpf = params['cpf'];
    });
  }

  save() {
    this.disableBtn = true;

    const id_cliente = this.cliente.id as number;

    const update_cliente = {
      nome: this.cliente.nome,
      cpf: this.cliente.cpf,
      email: this.cliente.email,
    };

    this.clientesService.update(update_cliente, id_cliente).subscribe(
      (resp: any) => {
        if (resp.status == 200) {
          this.router.navigate(['/clientes']);
        }
      },
      (resp) => {
        const errorMessage: string =
          resp.error?.message || 'Erro ao atualizar o cliente';
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
