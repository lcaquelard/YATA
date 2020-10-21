<?php

  namespace {
    class Travel
    {
      private static $properties = array(
       'type' =>          array('nullable' => false,  'depends_on' => NULL),
       'number' =>        array('nullable' => false,  'depends_on' => NULL),
       'departure' =>     array('nullable' => false,  'depends_on' => NULL),
       'arrival' =>       array('nullable' => false,  'depends_on' => NULL),
       'seat' =>          array('nullable' => true,  'depends_on' => NULL),
       'gate' =>          array('nullable' => true,  'depends_on' => array('type' => 'plane')),
       'baggage_drop' =>  array('nullable' => true,  'depends_on' => array('type' => 'plane')),
      );
      
      protected $steps = array();

      public function __construct($travel)
      {
        $iter = 0;
        if (!is_array($travel)) {
          $travel = json_decode($travel);
          if (is_object($travel))
            $travel = get_object_vars($travel);
          foreach ($travel as $key => $step) {
            if (is_object($step))
              $travel[$key] = get_object_vars($step);
          }
        }
        foreach ($travel as $step) {
          ++$iter;
          $this->new_step($step, $iter);
        }
      }

      public function get_array()
      {
        return ($this->steps);
      }

      private function new_step(array $entries, int $iter)
      {
        $step = array();
        $error = false;
          foreach (self::$properties as $property_name => $property)
          {
            if ($property['depends_on'] != NULL && $property['depends_on']['type'] != $entries['type']) {
              continue;
            }
            if ($property['nullable'] == false && (!array_key_exists($property_name, $entries) || $entries[$property_name] == NULL || $entries[$property_name] == '') )
            {
              echo ("ERROR : The parameter $property_name must have a value, none given in step $iter.<br>");
              $error = true;
            } else {
              $this->steps[$iter][$property_name] = $entries[$property_name];
            }
          }
        if ($error !== false)
          $this->steps[] = $step;
      }

      public function print()
      {
        $print = '';
        foreach ($this->steps as $step)
        {
          $string = '- Taking '.$step['type'].' '.$step['number'].' on seat '.$step['seat'].', departing from '.$step['departure'].' and going to '.$step['arrival'].'.';
          if ($step['type'] == 'plane')
          {
            $string .= 'Boarding is to happen gate '.$step['gate'].' and baggages will be dropped at desk '.$step['baggage_drop'].'.';
          }
          $string .= '<br><br>';
          $print .= $string;
        }
        return ($print);
      }
    }
  }