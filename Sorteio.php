<?php
    class Sorteio 
    {
        private $quantidade_dezenas;
        private $resultado;
        private $total_jogos;
        private $jogos;
    
        public function __construct($qtd_dezenas, $total_jogos)
        {    
            if ($qtd_dezenas < 6 || $qtd_dezenas > 10) {
                throw new Exception('Error 001: Quantidade de dezenas inválida ('. $qtd_dezenas. '). Valores permitidos: 6, 7, 8, 9, 10');
            }
            $this->quantidade_dezenas = $qtd_dezenas;
            $this->total_jogos = $total_jogos;
        }

        public function __set($value, $attr) {
            $this->$attr = $value;
        }
        public function __get($attr)
        {
            return $this->$attr;
        }

        private function cartela() {
            $numeros = array();
           
            $i = 1;
            while( $i <= $this->quantidade_dezenas ) {
             $numero = rand( 1,60 );
             if( ! in_array( $numero, $numeros ) ) {
              $numeros[] = $numero;
              ++$i;
             }
            }
            sort( $numeros );
           
            return $numeros;
        }

        public function gera() {
            $jg = [];
            for($i = 1; $i <= $this->total_jogos; $i++) {
                $jg[$i] = $this->cartela();
            }
            $this->jogos = $jg;
            return $jg;
        }

        public function sorteio() {
            $resultados = array();
           
            $i = 1;
            while( $i <= $this->quantidade_dezenas ) {
             $numero = rand( 1,60 );
             if( ! in_array( $numero, $resultados ) ) {
              $resultados[] = $numero;
              ++$i;
             }
            }
            sort( $resultados );
           
            $this->resultado =  $resultados;
        }

        public function confere() {
            $html = '<html><head><title>Sorteio</title></head><body style="text-align:center"><h2>Resultado</h2>';
            foreach($this->resultado as $num) {
                $html .= '<span style="font-size: 24px; font-weight: bold">'.$num.'</span> - ';
            }
            $html = rtrim($html, ' - ');
            $html .= '<hr>';
            $html .= '<h3>Jogos ('.$this->total_jogos.')</h3>';

            $jogos_tab = '<table style="width: auto; max-width: 700px; margin: 0 auto;"><thead><th style="font-size: 20px">Jogo</th>';
            for($j = 1; $j <= $this->quantidade_dezenas; $j++){
                $jogos_tab .= '<th>'.$j.'</th>';
            }
            $jogos_tab .= '</thead>';
            $jogos_tab .= '<tbody>';
            // var_dump($jogos_tab);
            foreach($this->jogos as $i => $cartela) {
                $jogos_tab .= '<tr><td style="text-align: right; padding: 10px; font-size: 24px; font-weight: bold">#'. $i.'</td>';
                foreach($cartela as $numero) {
                    if(in_array($numero, $this->resultado)) {
                        $jogos_tab .= '<td style="background-color: green; color:white; padding: 16px; text-align: center; font-size: 30px">'.$numero.'</td>';
                    } else {
                        $jogos_tab .= '<td style="background-color: red; color:white; padding: 16px; text-align: center; font-size: 30px">'.$numero.'</td>';
                    }
                }
                $jogos_tab .= '</tr>';
            }
            $jogos_tab .= '</tbody></table>';
            $html .= $jogos_tab;

            $html .= '</body></html>';
            echo $html;
        }
    }

    $r = new Sorteio(10,5);
    $r->gera();
    $r->sorteio();
    // $r->resultado;
    $r->confere();
?>