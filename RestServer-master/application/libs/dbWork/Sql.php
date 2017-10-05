<?php
/*
 *Base class for SQL connect
 *Based on fluid interface template
 *
 *
 */
namespace application\libs\dbWork;
class Sql
{
	protected $connectionLink;
	protected $selectVal;
	protected $insertVal;
	protected $deleteVal;
	protected $updateVal;
	protected $valuesVal;
	protected $setVal;
	protected $fromVal;
	protected $whereVal;
    
    
    protected $joinVal;
    protected $onVal;
    protected $groupVal;
    protected $havingVal;
    protected $orderVal;
    protected $limitVal;
    
    protected $currentOperation;
	
	/*
	*Function for seting valuse of insert action
	 */
	public function setInsertVal($table,  $colums)
	{
		$this->insertVal = " INSERT INTO " .  $table . " (" . $colums . " )";
		return $this;
	}

	/*
	*Function for seting values of value part query
	 */
	public function setValuesVal($values)
	{
		$this->valuesVal = " VALUES " . " (" . $values . " )";
		return $this;
	}

	/*
	*Function for seting values of SET part query
	 */
	public function setSetVal(  $colValstring)
	{
		$this->setVal = " SET " . " " . $colValstring . " ";
		return $this;
	}

	/*
	*Function for seting value of select action
	 */
	public function setSelectVal($cols, $distinct = false)
	{	
		if('distinct' === $distinct)
		{
			$distinct = ' DISTINCT ';
		}
		else
		{
			$distinct = '';
		}
		
        if("*" !== $cols)
		{
			$this->selectVal = " SELECT " . $distinct  .  $cols;
			
		}
		else
		{
			throw new Exception(SEL_ALL_ERR);
		}
		
		return $this;
    }
    
    	
	
	/*
	*Function for seting valuse of delete action
	 */
	public function setDeleteVal( $tableName)
	{
		if("*" !== $cols)
		{
			$this->deleteVal = " DELETE FROM " .  $tableName;
		}
		else
		{
			throw new Exception(SEL_ALL_ERR);
		}
		return $this;
	}

	/*
	*Function for seting valuse of update action
	 */
	public function setUpdateVal( $tableName)
	{
		if("*" !== $cols)
		{
			$this->updateVal = " UPDATE " . $tableName;
		}
		else
		{
			throw new Exception(SEL_ALL_ERR);
		}
		
		return $this;
	}

	/*
	*Function for seting table name for queries
	 */
	public function setFromVal( $tableName)
	{
		$this->fromVal = " FROM " .  $tableName;
		return $this;
	}

	/*
	*Function for seting valuse of condition in query
	 */
	public function setWhereVal( $condition)
	{
		$this->whereVal = " WHERE " .  $condition;
		return $this;
	}

	/*
	*Function for seting valuse of INNER JOIN in query
	 */
	public function setInnJoinVal($value)
	{
		$this->joinVal = " INNER JOIN " .  $value;
		return $this;
	}
	
	/*
	*Function for seting valuse of LEFT JOIN in query
	 */
	public function setLeftJoinVal($value)
	{
		$this->joinVal = " LEFT JOIN " .  $value;
		return $this;
	}
	
	/*
	*Function for seting valuse of RIGHT JOIN in query
	 */
	public function setRightJoinVal($value)
	{
		$this->joinVal = " RIGHT JOIN " .  $value;
		return $this;
	}
	
	/*
	*Function for seting valuse of CROSS JOIN in query
	 */
	public function setCrossJoinVal($value)
	{
		$this->joinVal = " CROSS JOIN " .  $value;
		return $this;
	}
	
	/*
	*Function for seting valuse of NATURAL JOIN in query
	 */
	public function setNaturalJoinVal($value)
	{
		$this->joinVal = " NATURAL JOIN " .  $value;
		return $this;
	}
	
	/*
	*Function for seting valuse of On in query
	 */
	public function setOnVal( $condition)
	{
		$this->onVal = " ON " .  $condition;
		return $this;
	}
	
	/*
	*Function for seting valuse of GROUP BY in query
	 */
	public function setGroupVal($value)
	{
		$this->groupVal = " GROUP BY " .  $value;
		return $this;
	}
	
	/*
	*Function for seting valuse of ORDER BY in query
	 */
	public function setOrderVal($value)
	{
		$this->orderVal = " ORDER BY " .  $value;
		return $this;
	}
	
	/*
	*Function for seting valuse of condition Having in query
	 */
	public function setHavingVal( $condition)
	{
		$this->havingVal = " HAVING " .  $condition;
		return $this;
	}
	
	/*
	*Function for seting valuse of limit in query
	 */
	public function setLimitVal( $condition)
	{
		$this->limitVal = " LIMIT " .  $condition;
		return $this;
	}
	
	/*
	*Function for reseting select, insert,update,delete values
	* for next query
	 */
	public function resetVal()
	{
		$this->selectVal = false;
		$this->insertVal = false;
		$this->updateVal = false;
        $this->deleteVal = false;
		$this->valuesVal = false;
		$this->setVal = false;
		$this->fromVal = false;
		$this->whereVal = '';
		$this->joinVal = false;
		$this->onVal = false;
		$this->groupVal = false;
		$this->havingVal = false;
		$this->orderVal = false;
		$this->limitVal = false;
		return 1;
	}

	/*
	*Function for sending query in db and getting result
	 */
	public function sendQueryString()
	{
		$query;
		
		switch(true)
		{
			case !empty($this->selectVal) && $this->selectVal !== SEL_ALL_ERR:
				$query =  $this->selectVal .  $this->fromVal . $this->joinVal . $this->onVal .  $this->whereVal . $this->groupVal . $this->havingVal . $this->orderVal . $this->limitVal;
				$this->currentOperation = 1;  
				break;
			case !empty($this->insertVal):
				$query = $this->insertVal . $this->valuesVal . $this->whereVal ; 
				$this->currentOperation = 0;
				break;
			case !empty($this->updateVal) && $this->updateVal !== SEL_ALL_ERR:
				$query = $this->updateVal . $this->setVal . $this->whereVal . $this->limitVal; 
				$this->currentOperation = 0;
				break;
			case !empty($this->deleteVal) && $this->deleteVal !== SEL_ALL_ERR:
				$query = $this->deleteVal . $this->whereVal . $this->limitVal ; 
				$this->currentOperation = 0;
				break;    
        }
        $this->resetVal();
	return  $query;
	}

}
