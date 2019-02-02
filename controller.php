<?php


class controller
{
    public function proses($data)
    {
        $this->original_data  = $data;

        $this->dokumen=array_filter(explode(".", $data), function ($value) {
            return $value !== '';
        });
        $this->filtering_data = $this->proses_filtering();
        $this->filtering_data =explode(" ", $this->filtering_data);

        $this->stopword_remove= $this->filtering_data;
        $this->proses_stopword();
        $this->pembobotan_kata();
        $this->pembobotan_kalimat();
        $this->pengurutan();
        $this->pengurutan1();
    }


    public function pengurutan1()
    {
        $urutan=array();
        $t=0;
        foreach ($this->urutan as $key) {
            $urutan[$t]=array_sum($key['df']);
            ++$t;
        }
        arsort($urutan);
        $this->urutan1=$urutan;
        session_start();
        $_SESSION['table1']=$this->table1;
        $_SESSION['table2']=$this->table2;
        $_SESSION['original_data']=$this->original_data;
        $_SESSION['urutan1']=$this->urutan;
        $_SESSION['urutan2']=$this->urutan1;
        header("Location: hasil.php");
    }

    public function pengurutan()
    {
        $q=0;
        $urutan=array();

        foreach ($this->table1[0]['dok'] as $key) {//6
            $term=array();
            $df=array();
            $o=0;//40
            foreach ($this->table1 as $key1) { //40
                if ($this->table1[$o]['dok'][$q]>0) {
                    array_push($term, $this->table1[$o]['term']);
                    array_push($df, $this->table1[$o]['df']);
                }
                ++$o;
            }
            $urutan[$q]['term']=$term;
            $urutan[$q]['df']=$df;
            ++$q;//5
        }
        $this->urutan=$urutan;
        //    echo json_encode($urutan);
    }


    public function pembobotan_kalimat()
    {
        $bobot_dokumen=array();
        $y=0;
        foreach ($this->dokumen as $key1) {
            $bobot_dokumen[$y]['a']=array();
            foreach ($this->table1 as $key2) {
                //   echo $key2['dok'][$y] ;
                if ($key2['dok'][$y]>0) {
                    array_push($bobot_dokumen[$y]['a'], $key2['dok'][$y]*$key2['idf1']);
                } else {
                    array_push($bobot_dokumen[$y]['a'], 0);
                }
            }
            $bobot_dokumen[$y]['jml']=round(array_sum($bobot_dokumen[$y]['a']), 3);
            ++$y;
        }
        $this->table2=$bobot_dokumen;
    }

    public function pembobotan_kata()
    {
        $l=0;
        $table1=array();
        $search=array();
        foreach ($this->stopword_remove as $key) {
            if (array_search(trim(strtolower($key)), $search)===false) {
                $dok=0;
                $table1[$l]['term']=trim(strtolower($key));
                $table1[$l]['dok']=array();

                foreach ($this->dokumen as $key1) {
                    array_push($table1[$l]['dok'], substr_count(trim(strtolower($key1)), trim(strtolower($key))));


                    ++$dok;
                }

                $table1[$l]['df']=array_sum($table1[$l]['dok']);
                $table1[$l]['Ddf']=count($table1[$l]['dok'])/$table1[$l]['df'];
                $table1[$l]['idf']=round(log10($table1[$l]['Ddf']), 3);
                $table1[$l]['idf1']= round($table1[$l]['idf']+1, 3);
                ++$l;
            }
            array_push($search, trim(strtolower($key)));
        }
        $this->table1=$table1;
        //  echo json_encode($table1);
    }

    public function proses_filtering()
    {
        $filtering = str_replace("\n", ' ', $this->original_data);
        $filtering = str_replace(",", '', $filtering);
        $filtering = str_replace('"', '', $filtering);
        $filtering = str_replace('.', '', $filtering);
        $filtering = str_replace("'", '', $filtering);
        $filtering = preg_replace('/ ([\'"()*),.:…;?`\n]) /', '', $filtering);
        $filtering = preg_replace('/ +/', ' ', $filtering);
        return $filtering;
    }




    public function proses_stopword()
    {
        $t=0;
        foreach ($this->stopword_remove as $term) {
            $fh = fopen('data/stopword.txt', 'r');
            while ($line = fgets($fh)) {
                if (trim($line)==trim($term)) {
                    unset($this->stopword_remove[$t]);
                    break;
                }
            }

            fclose($fh);
            ++$t;
        }
    }
}
