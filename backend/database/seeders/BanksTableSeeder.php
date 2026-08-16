<?php

namespace Database\Seeders;

use App\Models\Bank;
use Illuminate\Database\Seeder;

class BanksTableSeeder extends Seeder
{
    /** TODO: conferir se o link de simulação segue válido antes de publicar. */
    public function run(): void
    {
        $banks = [
            [
                'name' => 'Caixa Econômica Federal',
                'link_simulation' => 'https://simuladorhabitacao.caixa.gov.br/home',
                'description' => 'Principal agente do Minha Casa Minha Vida e do FGTS, com as menores taxas do mercado para imóveis residenciais.',
                'instructions' => "1. Acesse o simulador da Caixa.\n2. Informe o valor do imóvel e a cidade.\n3. Escolha o programa Minha Casa Minha Vida, se elegível.\n4. Confira parcela, subsídio e taxa antes de agendar na agência.",
            ],
        ];

        foreach ($banks as $bank) {
            Bank::updateOrCreate(
                ['name' => $bank['name']],
                [
                    'link_simulation' => $bank['link_simulation'],
                    'description' => $bank['description'],
                    'instructions' => $bank['instructions'],
                    'is_active' => true,
                ],
            );
        }
    }
}
