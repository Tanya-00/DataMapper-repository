<?php 

class Cinema {
    private $movieID;
    private $movieName;
    private $director;

    public function __construct($movieID, $movieName, $director) {
        $this->movieID = $movieID;
        $this->movieName = $movieName;
        $this->director = $director;  
    }
}

class mapper {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function save(Cinema $cinema) {
        $request = $this->pdo->prepare("INSERT INTO cinema (movieID, movieName, director) VALUE (:movieID, :movieName, :director)");
        $request->execute([
          "movieID"=>$this->movieID,
          "movieName"=>$this->movieName,
          "director"=>$this->director
        ]);
    }

    public function remove(Cinema $cinema) {
        $request = $this->pdo->prepare("DELETE INTO cinema WHERE movieID = $this->movieID");
        $this->pdo->exec($request);
    }

    public function getByID(Cinema $movieID) {
        $request = $this->pdo->prepare("SELECT * FROM cinema WHERE movieID = $movieID");
        $request->execute([$movieID]);
        $allData = $request->fetchAll();
        $data = count($allData);
        if($data = 0) {
          echo 'movie not found';
        }
        else {
          $this->movieID = $allData['movieID'];
          $this->movieName = $allData['movieName'];
          $this->director = $allData['director'];
        }
    }

    public function all() : array {
        $request = $this->pdo->prepare("SELECT * FROM cinema");
        $request->execute();
        $allData = $request->fetchAll();
        return $allData;
    }

    public function getByDirector(Cinema $director) : array {
        $request = $this->pdo->prepare("SELECT * FROM cinema WHERE director = $director");
        $request->execute([$director]);
        $allData = $request->fetchAll();
        $data = count($allData);
        if($data = 0) {
          echo 'movie not found';
        }
        else {
          return $allData;
        }
    }
}

?>