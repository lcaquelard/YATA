<?php
namespace {

  class DB
  {
    private static $host = '127.0.0.1';
    private static $db = 'yata';
    private static $charset = 'utf8mb4';
    private static $user = 'root';
    private static $pass = '';

    private $pdo;

    public function __construct()
    {
      $dsn = 'mysql:host='.self::$host.';dbname='.self::$db.';charset='.self::$charset;
      $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
       PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
       PDO::ATTR_EMULATE_PREPARES => false,];
      try {
        $this->pdo = new PDO($dsn, self::$user, self::$pass, $options);
      } catch
      (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int)$e->getCode());
      }
    }

    public function fetch()
    {
      $travels = array();
      $stmt = $this->pdo->query('SELECT travel_id, `type`, `number`, departure, arrival, seat, gate, baggage_drop, `position` FROM step ORDER BY position');
      while ($step = $stmt->fetch())
      {
        $travel_id = $step['travel_id'];
        $position = $step['position'];
        unset($step['travel_id'], $step['position']);
        $travels[$travel_id][$position] = $step;
      }
      return ($travels);
    }

    public function insert(array $travel)
    {
      $sql_travel = 'INSERT INTO travel () VALUES ()';
      $sql_steps = 'INSERT INTO step (travel_id, `type`, `number`, departure, arrival, seat, gate, baggage_drop, `position`) VALUES ';
      $stmt = $this->pdo->prepare($sql_travel);
      $stmt->execute();
      $travel_id = $this->pdo->lastInsertId();
      foreach ($travel as $position => $step)
      {
        if ($step['seat'] == null)
          $step['seat'] = '44';
        $sql_step = '('.$travel_id.', \''.$step['type'].'\', \''.$step['number'].'\', \''.$step['departure'].'\', \''.$step['arrival'].'\', \''.$step['seat'].'\'';
        if ($step['type'] == 'plane')
          $sql_step .= ', \''.$step['gate'].'\', \''.$step['baggage_drop'].'\'';
        else
          $sql_step .= ', null, null';
        $sql_step .= ", $position),";
        $sql_steps .= $sql_step;
      }
      $sql_steps = substr($sql_steps, 0, -1);
      $stmt = $this->pdo->prepare($sql_steps);
      try {
        $stmt->execute();
      } catch (PDOException $e){
        echo $e->getMessage();
      }
    }
  }
}