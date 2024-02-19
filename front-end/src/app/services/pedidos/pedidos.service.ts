import { Injectable } from '@angular/core';
import { environment } from '../../../environments/environment.development';
import { HttpClient } from '@angular/common/http';

@Injectable({
  providedIn: 'root',
})
export class PedidosService {
  private url = environment.api;

  constructor(private httpClient: HttpClient) {}

  getPedidos() {
    return this.httpClient.get<any>(this.url + '/api/pedidos');
  }
}
