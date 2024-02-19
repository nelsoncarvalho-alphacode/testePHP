import { Injectable } from '@angular/core';
import { environment } from '../../../environments/environment.development';
import { HttpClient } from '@angular/common/http';
import { Cliente } from '../../models/Cliente';

@Injectable({
  providedIn: 'root',
})
export class ClientesService {
  private url = environment.api + '/api/clientes';

  constructor(private httpClient: HttpClient) {}

  getClientes() {
    return this.httpClient.get<any>(this.url);
  }

  getAllClientes() {
    return this.httpClient.get<any>(this.url + '-all');
  }

  save(cliente: Partial<Cliente>) {
    return this.httpClient.post<any>(this.url, cliente);
  }

  delete(id_cliente: number) {
    return this.httpClient.delete(this.url + `/${id_cliente}`);
  }

  update(cliente: Partial<Cliente>, id: number) {
    return this.httpClient.put(this.url + `/${id}`, cliente);
  }
}
