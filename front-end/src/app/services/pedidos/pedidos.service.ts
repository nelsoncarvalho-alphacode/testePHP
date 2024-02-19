import { Injectable } from '@angular/core';
import { environment } from '../../../environments/environment.development';
import { HttpClient } from '@angular/common/http';
import { Pedido } from '../../models/Pedido';

@Injectable({
  providedIn: 'root',
})
export class PedidosService {
  private url = environment.api + '/api/pedidos';

  constructor(private httpClient: HttpClient) {}

  getPedidos() {
    return this.httpClient.get<any>(this.url);
  }

  getAllPedidos() {
    return this.httpClient.get<any>(this.url + '-all');
  }

  save(pedido: Partial<Pedido>) {
    return this.httpClient.post<any>(this.url, pedido);
  }

  update(pedido: Partial<Pedido>, id: number) {
    return this.httpClient.put<any>(this.url + `/${id}`, pedido);
  }

  delete(id_pedido: number) {
    return this.httpClient.delete(this.url + `/${id_pedido}`);
  }
}
