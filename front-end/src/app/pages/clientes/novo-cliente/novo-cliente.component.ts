import { Component } from '@angular/core';
import { ClientesService } from '../../../services/clientes/clientes.service';
import { Location } from '@angular/common';
import { Router } from '@angular/router';
import { MatSnackBar } from '@angular/material/snack-bar';
import { Cliente } from '../../../models/Cliente';
import { MatFormFieldModule } from '@angular/material/form-field';
import { MatInputModule } from '@angular/material/input';
import { FormsModule } from '@angular/forms';
import { MatButtonModule } from '@angular/material/button';

@Component({
  selector: 'app-novo-cliente',
  standalone: true,
  imports: [MatFormFieldModule, MatInputModule, FormsModule, MatButtonModule],
  templateUrl: './novo-cliente.component.html',
  styleUrl: './novo-cliente.component.scss',
})
export class NovoClienteComponent {
  cliente: Partial<Cliente> = {
    nome: '',
    cpf: '',
    email: '',
  };

  disableBtn: boolean = false;

  constructor(
    private clienteService: ClientesService,
    private location: Location,
    private router: Router,
    private _snackBar: MatSnackBar
  ) {}

  save() {
    this.disableBtn = true;

    this.clienteService.save(this.cliente).subscribe(
      (resp: any) => {
        if (resp.status == 201) {
          this.router.navigate(['/clientes']);
        }
      },
      (resp) => {
        const errorMessage: string =
          resp.error?.message || 'Erro ao cadastrar o cliente';
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
