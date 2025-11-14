<?php 

abstract class AbstractEntity{
    protected $id = null;
    

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId(int|string $id)
    {
        $this->id = $id;

        return $this;
    }


    public function __construct(array $data = [])
    {
        if (!empty($data)) {
            $this->hydrate($data);
        }
    }


    protected function hydrate(array $data){
        foreach ($data as $key => $value) {
           $method = 'set' . str_replace('_','',ucwords($key,'_'));
           if (method_exists($this,$method)) {
                $this->$method($value);
           }
        }
    }
}