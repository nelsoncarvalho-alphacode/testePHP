import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { Produto } from '../../../models/Produto';
import { MatFormFieldModule } from '@angular/material/form-field';
import { MatInputModule } from '@angular/material/input';
import { FormsModule } from '@angular/forms';
import { MatButtonModule } from '@angular/material/button';
import { ProdutosService } from '../../../services/produtos/produtos.service';
import { Location } from '@angular/common';
import { MatSnackBar } from '@angular/material/snack-bar';

@Component({
  selector: 'app-editar-produto',
  standalone: true,
  imports: [MatFormFieldModule, MatInputModule, FormsModule, MatButtonModule],
  templateUrl: './editar-produto.component.html',
  styleUrl: './editar-produto.component.scss',
})
export class EditarProdutoComponent implements OnInit {
  produto: Partial<Produto> = {
    id: 0,
    nome: '',
    cod_barras: '',
    qtd_prod: 1,
    valor: 0,
  };

  disableBtn: boolean = false;

  constructor(
    private route: ActivatedRoute,
    private produtoService: ProdutosService,
    private location: Location,
    private router: Router,
    private _snackBar: MatSnackBar
  ) {}

  ngOnInit(): void {
    this.route.queryParams.subscribe((params) => {
      this.produto.id = params['id'];
      this.produto.nome = params['nome'];
      this.produto.cod_barras = params['cod_barras'];
      this.produto.qtd_prod = params['qtd_prod'];
      this.produto.valor = params['valor'];
    });
  }

  save() {
    this.disableBtn = true;

    const id_produto = this.produto.id as number;
    const update_produto = {
      nome: this.produto.nome,
      cod_barras: this.produto.cod_barras,
      qtd_prod: this.produto.qtd_prod,
      valor: this.produto.valor,
    };

    this.produtoService.update(update_produto, id_produto).subscribe(
      (resp: any) => {
        if (resp.status == 200) {
          this.router.navigate(['/']);
        }
      },
      (resp) => {
        const errorMessage: string =
          resp.error?.message || 'Erro ao atualizar o produto';
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
