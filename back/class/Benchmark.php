<?php

class Benchmark{
    private string $name;
    private float $start;
    private float $end;
    private float $time;

    public function __construct(string $name){
        $this->name = $name;
        $this->start =0;
        $this->end = 0;
        $this->time = 0;
    }

    public function GetName():string{
        return $this->name;
    }
    public function GetTime():float{
        return $this->time;
    }
    public function GetBenchmark():string{
        return "Temps d'exécution de " . $this->name . " : " . $this->time . " ms";
    }

    public function StartBenchmark(): void{
        $this->start = microtime(true);
    }
    public function EndBenchmark():void{
        $this->end = microtime(true);
        $this->time = round((($this->end - $this->start)*1000));
    }

}