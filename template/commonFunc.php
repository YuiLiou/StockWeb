<?php
  /*************************漲跌率**********************************/
  function getRateTd($value)
  {
      if ($value > 0)
          return "<td class='up'>".$value."%</td>";
      else if($value < 0)
          return "<td class='down'>".$value."%</td>";
      else
          return "<td class='same'>0%</td>";
  }
  /*************************連續紀錄td*******************************/
  function getContinuousTd($value)
  {
      if ($value == 1)
          return "<td class='up'>轉虧為盈</td>";
      else if ($value > 1)    
          return "<td class='up'>連續".$value."季成長</td>";
      else if ($value == -1)
          return "<td class='down'>轉盈為虧</td>";
      else if ($value < -1)    
          return "<td class='down'>連續".-1*$value."季虧損</td>";
  }
  /**************************發送率td***********************************/
  function getDispatchTd($value)
  {
      if ($value > 60) 
          return "<td class='up'>".round($value,2)."%</td>"; 
      else if ($value < 40)    
          return "<td class='down'>".round($value,2)."%</td>";
      else 
          return "<td>".round($value,2)."</td>";
  }
?>
