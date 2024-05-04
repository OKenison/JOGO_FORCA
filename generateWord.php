<?php

function generateWord($dificuldade) {

    $easyLevel = array(
        "album" => "Uma coleção de músicas ou fotos gravadas",
        "agua" => "Uma substância líquida essencial para a vida. ",
        "cruz" => "Um símbolo que consiste em duas linhas que se cruzam",
        "casa" => "Um lugar onde as pessoas vivem e dormem. ",
        "elefante" => "Um mamífero de grande porte com tronco e orelhas grandes.",
        "mesa" => "Móvel com quatro pernas, usado para refeições.",
        "radio" => "Transmissão e recepção de ondas eletromagnéticas"
    );
    $mediumLevel = array(
        "oftalmologista" => "Médico especialista em olhos.",
        "computador" => "Uma máquina eletrônica usada para processar informações e executar programas.",
        "janela" => "Abertura na parede para ventilação e luz.",
        "tigre" => "Um grande felino com listras laranjas e pretas.",
        "pao" => "Um alimento feito de farinha, água e fermento"
    );
    $hardLevel = array(
        "jurisprudência" => "Decisões judiciais que servem como referência.",
        "labirinto" => "Um caminho complexo e confuso com muitos corredores e passagens",
        "criptografia" => " O estudo de escrever ou resolver códigos secretos",
        "paralelepípedo" => "Sólido geométrico com faces retangulares.",
        "esfinge" => "Uma criatura mítica com corpo de leão e cabeça humana, famosa no Egito antigo."
    );


    if ($dificuldade == "facil") {
        $words = $easyLevel;
    } elseif ($dificuldade == "medio") {
        $words = $mediumLevel;
    } elseif ($dificuldade == "dificil") {
        $words = $hardLevel;
    } else {
        $words = $easyLevel; 
    }

    $randomKey = array_rand($words);
    $palavra = $randomKey;
    $dica = $words[$randomKey];
    
    return ['palavra' => $palavra, 'dica' => $dica];
}


?>
