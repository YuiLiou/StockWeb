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
  /*************************漲跌****************************************/
  function getMarkedTd($value)
  {
      if ($value > 0)
          return "<td class='up'>".$value."</td>";
      else if($value < 0)
          return "<td class='down'>".$value."</td>";
      else
          return "<td class='same'>0</td>";
  } 
?>
