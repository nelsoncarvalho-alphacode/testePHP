import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { environment } from '../../../environments/environment.development';

@Injectable({
  providedIn: 'root',
})
export class ProdutosService {
  private url = environment.api + '/api/produtos';

  constructor(private httpClient: HttpClient) {}

  getProdutos() {
    return this.httpClient.get<any>(this.url);
  }

  getProdutoById(id: number) {
    return this.httpClient.get<any>(this.url + id);
  }
}
