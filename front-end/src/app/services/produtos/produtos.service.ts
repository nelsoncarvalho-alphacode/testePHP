import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { environment } from '../../../environments/environment.development';
import { Produto } from '../../models/Produto';

@Injectable({
  providedIn: 'root',
})
export class ProdutosService {
  private url = environment.api + '/api/produtos';

  constructor(private httpClient: HttpClient) {}

  getProdutos() {
    return this.httpClient.get<any>(this.url);
  }

  getAllProdutos() {
    return this.httpClient.get<any>(this.url + '-all');
  }

  save(produto: Partial<Produto>) {
    return this.httpClient.post(this.url, produto);
  }

  delete(id_produto: number) {
    return this.httpClient.delete(this.url + `/${id_produto}`);
  }

  update(produto: Partial<Produto>, id: number) {
    return this.httpClient.put(this.url + `/${id}`, produto);
  }
}
