<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('clients')->insert([
            ['name' => 'João', 'surname' => 'Silva Santos', 'cpf' => '12345678901', 'email' => 'joao.silva@email.com'],
            ['name' => 'Maria', 'surname' => 'Oliveira Costa', 'cpf' => '23456789012', 'email' => 'maria.oliveira@email.com'],
            ['name' => 'Pedro', 'surname' => 'Souza Lima', 'cpf' => '34567890123', 'email' => 'pedro.souza@email.com'],
            ['name' => 'Ana', 'surname' => 'Ferreira Alves', 'cpf' => '45678901234', 'email' => 'ana.ferreira@email.com'],
            ['name' => 'Carlos', 'surname' => 'Rodrigues Pereira', 'cpf' => '56789012345', 'email' => 'carlos.rodrigues@email.com'],
            ['name' => 'Lucia', 'surname' => 'Martins Barbosa', 'cpf' => '67890123456', 'email' => 'lucia.martins@email.com'],
            ['name' => 'Rafael', 'surname' => 'Gomes Silva', 'cpf' => '78901234567', 'email' => 'rafael.gomes@email.com'],
            ['name' => 'Camila', 'surname' => 'Nascimento Rocha', 'cpf' => '89012345678', 'email' => 'camila.nascimento@email.com'],
            ['name' => 'Bruno', 'surname' => 'Carvalho Mendes', 'cpf' => '90123456789', 'email' => 'bruno.carvalho@email.com'],
            ['name' => 'Fernanda', 'surname' => 'Ribeiro Santos', 'cpf' => '01234567890', 'email' => 'fernanda.ribeiro@email.com'],
            ['name' => 'Gustavo', 'surname' => 'Almeida Dias', 'cpf' => '11234567890', 'email' => 'gustavo.almeida@email.com'],
            ['name' => 'Juliana', 'surname' => 'Teixeira Nunes', 'cpf' => '22345678901', 'email' => 'juliana.teixeira@email.com'],
            ['name' => 'Ricardo', 'surname' => 'Moreira Castro', 'cpf' => '33456789012', 'email' => 'ricardo.moreira@email.com'],
            ['name' => 'Patrícia', 'surname' => 'Azevedo Pinto', 'cpf' => '44567890123', 'email' => 'patricia.azevedo@email.com'],
            ['name' => 'Marcelo', 'surname' => 'Cardoso Vieira', 'cpf' => '55678901234', 'email' => 'marcelo.cardoso@email.com'],
            ['name' => 'Renata', 'surname' => 'Fonseca Reis', 'cpf' => '66789012345', 'email' => 'renata.fonseca@email.com'],
            ['name' => 'Diego', 'surname' => 'Correia Lopes', 'cpf' => '77890123456', 'email' => 'diego.correia@email.com'],
            ['name' => 'Vanessa', 'surname' => 'Campos Miranda', 'cpf' => '88901234567', 'email' => 'vanessa.campos@email.com'],
            ['name' => 'Thiago', 'surname' => 'Nogueira Franco', 'cpf' => '99012345678', 'email' => 'thiago.nogueira@email.com'],
            ['name' => 'Larissa', 'surname' => 'Monteiro Xavier', 'cpf' => '10123456789', 'email' => 'larissa.monteiro@email.com'],
            ['name' => 'Felipe', 'surname' => 'Cunha Batista', 'cpf' => '21234567890', 'email' => 'felipe.cunha@email.com'],
            ['name' => 'Gabriela', 'surname' => 'Freitas Morais', 'cpf' => '32345678901', 'email' => 'gabriela.freitas@email.com'],
            ['name' => 'André', 'surname' => 'Barbosa Leite', 'cpf' => '43456789012', 'email' => 'andre.barbosa@email.com'],
            ['name' => 'Cristina', 'surname' => 'Pires Machado', 'cpf' => '54567890123', 'email' => 'cristina.pires@email.com'],
            ['name' => 'Lucas', 'surname' => 'Melo Araújo', 'cpf' => '65678901234', 'email' => 'lucas.melo@email.com'],
            ['name' => 'Priscila', 'surname' => 'Duarte Silveira', 'cpf' => '76789012345', 'email' => 'priscila.duarte@email.com'],
            ['name' => 'Rodrigo', 'surname' => 'Cavalcanti Moura', 'cpf' => '87890123456', 'email' => 'rodrigo.cavalcanti@email.com'],
            ['name' => 'Tatiana', 'surname' => 'Vasconcelos Coelho', 'cpf' => '98901234567', 'email' => 'tatiana.vasconcelos@email.com'],
            ['name' => 'Fabio', 'surname' => 'Borges Ramos', 'cpf' => '09012345678', 'email' => 'fabio.borges@email.com'],
            ['name' => 'Adriana', 'surname' => 'Leal Soares', 'cpf' => '19123456789', 'email' => 'adriana.leal@email.com'],
            ['name' => 'Vinicius', 'surname' => 'Torres Figueiredo', 'cpf' => '28234567890', 'email' => 'vinicius.torres@email.com'],
            ['name' => 'Simone', 'surname' => 'Brandão Tavares', 'cpf' => '37345678901', 'email' => 'simone.brandao@email.com'],
            ['name' => 'Danilo', 'surname' => 'Matos Carneiro', 'cpf' => '46456789012', 'email' => 'danilo.matos@email.com'],
            ['name' => 'Carla', 'surname' => 'Guimarães Antunes', 'cpf' => '57567890123', 'email' => 'carla.guimaraes@email.com'],
            ['name' => 'Marcos', 'surname' => 'Siqueira Caldeira', 'cpf' => '68678901234', 'email' => 'marcos.siqueira@email.com'],
            ['name' => 'Roberta', 'surname' => 'Macedo Esteves', 'cpf' => '79789012345', 'email' => 'roberta.macedo@email.com'],
            ['name' => 'Leandro', 'surname' => 'Paiva Rezende', 'cpf' => '80890123456', 'email' => 'leandro.paiva@email.com'],
            ['name' => 'Sandra', 'surname' => 'Neves Portela', 'cpf' => '91901234567', 'email' => 'sandra.neves@email.com'],
            ['name' => 'Eduardo', 'surname' => 'Sampaio Godoy', 'cpf' => '02012345678', 'email' => 'eduardo.sampaio@email.com'],
            ['name' => 'Monica', 'surname' => 'Veloso Marques', 'cpf' => '13123456789', 'email' => 'monica.veloso@email.com'],
        ]);
    }
}
