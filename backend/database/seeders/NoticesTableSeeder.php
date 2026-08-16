<?php

namespace Database\Seeders;

use App\Models\Notice;
use Illuminate\Database\Seeder;

/**
 * Notícias reais extraídas de canopusconstrucoes.com.br/fortaleza (seção "Fique por dentro das novidades").
 * TODO: revisar textos e trocar imagens hotlinkadas por upload próprio antes de publicar.
 */
class NoticesTableSeeder extends Seeder
{
    public function run(): void
    {
        $notices = [
            [
                'title' => 'Canopus Construções é destaque no Ranking INTEC 2026',
                'slug' => 'canopus-construcoes-e-destaque-no-ranking-intec-2026',
                'excerpt' => 'Com 50 anos de atuação no mercado, a Canopus Construções aparece entre as maiores construtoras do Brasil no Ranking INTEC 2026.',
                'image_path' => 'https://canopusconstrucoes.com.br/storage/noticias/imagem_destaque/XtDYAK4zeOXC3m3Num2lzLGUmr4L6320260320000000.webp',
                'published_at' => '2026-03-20 00:00:00',
                'content' => <<<'HTML'
                    <p>Com 50 anos de atuação no mercado, a Canopus Construções construiu uma trajetória marcada por solidez, crescimento consistente e forte presença no setor da construção civil.</p>

                    <p>Na edição mais recente do Ranking INTEC das 100 Maiores Construtoras, a Canopus aparece novamente entre os destaques nacionais, reflexo de um trabalho consistente ao longo de décadas.</p>

                    <blockquote>"Estar entre as maiores construtoras do Brasil é resultado de um trabalho pautado em planejamento, responsabilidade e foco nas pessoas. Seguimos comprometidos em evoluir continuamente, expandir nossa presença e entregar empreendimentos que façam a diferença na vida das famílias." — Thiago Carvalho, VP da Canopus Construções</blockquote>

                    <h2>Compromisso com o Desenvolvimento</h2>
                    <p>Mais do que números, o reconhecimento no Ranking INTEC evidencia o compromisso da Canopus Construções com o desenvolvimento das cidades onde atua. Cada projeto entregue representa não apenas lares construídos, mas novas oportunidades, geração de empregos e transformação social.</p>

                    <h2>Visão de Futuro</h2>
                    <p>O reconhecimento no Ranking INTEC 2026 marca mais um capítulo importante na trajetória da Canopus Construções, que segue olhando para o futuro com foco em inovação, expansão e impacto positivo nas regiões onde atua.</p>
                    <p>Com bases sólidas e uma atuação cada vez mais abrangente, a construtora reafirma seu papel como uma das empresas que impulsionam o crescimento da construção civil no Brasil.</p>

                    <p><a href="https://imirante.com/noticias/sao-luis/2026/03/18/canopus-construcoes-e-destaque-no-ranking-intec-2026" target="_blank" rel="noopener noreferrer">Matéria de referência</a></p>
                    HTML,
            ],
            [
                'title' => 'Em megaevento, Canopus Construções lança dois novos empreendimentos em São Luís',
                'slug' => 'em-megaevento-canopus-construcoes-lanca-dois-novos-empreendimentos-em-sao-luis',
                'excerpt' => 'A construtora lançou o Village Garden II e o Village Prime Calhau II para cerca de 500 corretores em evento no UCI Kinoplex.',
                'image_path' => 'https://canopusconstrucoes.com.br/storage/noticias/imagem_destaque/mLBB4RWa97dSPqF03T6wp7Rai5P8Jn20240902000000.webp',
                'published_at' => '2024-09-02 00:00:00',
                'content' => <<<'HTML'
                    <p>A Canopus Construções lançou, em evento realizado nesta quarta-feira (14), dois empreendimentos que prometem movimentar o mercado imobiliário de São Luís: o Village Garden II, próximo ao Turu, e o Village Prime Calhau II, na região da Cohama.</p>

                    <p>O evento de lançamento dos dois novos empreendimentos da Canopus foi realizado em uma das salas de cinema do UCI Kinoplex, no Shopping da Ilha, que ficou pequena para os cerca de 500 corretores de imóveis que compareceram ao chamado da construtora para conhecer as novidades.</p>
                    HTML,
            ],
            [
                'title' => 'A Aliança Entre o Grupo Canopus e Grupo Mateus',
                'slug' => 'a-alianca-entre-o-grupo-canopus-e-grupo-mateus',
                'excerpt' => 'Canopus e Mateus reafirmam parceria e inauguram nova loja em Barreirinhas, na entrada dos Lençóis Maranhenses.',
                'image_path' => 'https://canopusconstrucoes.com.br/storage/noticias/imagem_destaque/sLvamkm2Rdq0svmbN9qo3DatkH8vL420240902000000.webp',
                'published_at' => '2024-09-02 00:00:00',
                'content' => <<<'HTML'
                    <p>O Grupo Canopus, um dos maiores players no segmento "Built to Suit – BTS" no Nordeste, e o Grupo Mateus, um dos maiores varejistas do Brasil, expandem sua parceria de sucesso. Em um cenário de visão estratégica e confiança mútua, Canopus e Mateus reafirmam a parceria e inauguram mais uma loja, localizada no portal de entrada para os Lençóis Maranhenses, na cidade de Barreirinhas, com um investimento de aproximadamente R$ 30 milhões.</p>

                    <p>A construção gerou mais de 300 empregos diretos e indiretos e prevê 240 empregos na operação do supermercado. Com 18.528 m² de terreno, 9.227,63 m² de área construída e 196 vagas de estacionamento, o novo empreendimento está estrategicamente localizado na entrada da cidade e atenderá toda a região, composta por quatro municípios e aproximadamente 125 mil habitantes.</p>

                    <p><a href="https://imirante.com/noticias/barreirinhas/2024/07/11/a-alianca-entre-o-grupo-canopus-e-grupo-mateus" target="_blank" rel="noopener noreferrer">Matéria de referência</a></p>
                    HTML,
            ],
        ];

        foreach ($notices as $notice) {
            Notice::updateOrCreate(
                ['slug' => $notice['slug']],
                [
                    'title' => $notice['title'],
                    'excerpt' => $notice['excerpt'],
                    'content' => $notice['content'],
                    'image_path' => $notice['image_path'],
                    'is_published' => true,
                    'published_at' => $notice['published_at'],
                ],
            );
        }
    }
}
