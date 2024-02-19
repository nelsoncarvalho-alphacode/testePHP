import { Component } from '@angular/core';
import { Produto } from '../../../models/Produto';
import { ProdutosService } from '../../../services/produtos/produtos.service';
import { MatFormFieldModule } from '@angular/material/form-field';
import { MatInputModule } from '@angular/material/input';
import { FormsModule } from '@angular/forms';
import { MatButtonModule } from '@angular/material/button';
import { Location } from '@angular/common';
import { Router } from '@angular/router';
import { MatSnackBar } from '@angular/material/snack-bar';

@Component({
  selector: 'app-novo-produto',
  standalone: true,
  imports: [MatFormFieldModule, MatInputModule, FormsModule, MatButtonModule],
  templateUrl: './novo-produto.component.html',
  styleUrl: './novo-produto.component.scss',
})
export class NovoProdutoComponent {
  produto: Partial<Produto> = {
    nome: '',
    cod_barras: '',
    qtd_prod: 1,
    valor: 0,
  };

  disableBtn: boolean = false;

  constructor(
    private produtoService: ProdutosService,
    private location: Location,
    private router: Router,
    private _snackBar: MatSnackBar
  ) {}

  save() {
    this.disableBtn = true;

    this.produtoService.save(this.produto).subscribe(
      (resp: any) => {
        if (resp.status == 201) {
          this.router.navigate(['/']);
        }
      },
      (resp) => {
        const errorMessage: string =
          resp.error?.message || 'Erro ao cadastrar o produto';
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
