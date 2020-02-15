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
  function getUpGroup($col_name, $this_value, $past_value, $grow)
  {
      $rslt = "";
      if ($grow >= 0)
      {
          $rslt .= "<tr>";
          $rslt .= "<td><font color='red'>".$col_name."</td>";
          $rslt .= "<td><font color='red'>".$this_value."</td>";
          $rslt .= "<td><font color='red'>".$past_value."</td>";
          $rslt .= "<td><font color='red'>".$grow."%</td>";
          $rslt .= "</tr>";
      }
      else 
      {
          $rslt .= "<tr>";
          $rslt .= "<td><font color='green'>".$col_name."</td>";
          $rslt .= "<td><font color='green'>".$this_value."</td>";
          $rslt .= "<td><font color='green'>".$past_value."</td>";
          $rslt .= "<td><font color='green'>".$grow."%</td>";
          $rslt .= "</tr>";
      }
      return $rslt;
  }
  function getDownGroup($col_name, $this_value, $past_value, $grow)
  {
      $rslt = "";
      if ($grow >= 0)
      {
          $rslt .= "<tr>";
          $rslt .= "<td><font color='green'>".$col_name."</td>";
          $rslt .= "<td><font color='green'>".$this_value."</td>";
          $rslt .= "<td><font color='green'>".$past_value."</td>";
          $rslt .= "<td><font color='green'>".$grow."%</td>";
          $rslt .= "</tr>";
      }
      else 
      {
          $rslt .= "<tr>";
          $rslt .= "<td><font color='red'>".$col_name."</td>";
          $rslt .= "<td><font color='red'>".$this_value."</td>";
          $rslt .= "<td><font color='red'>".$past_value."</td>";
          $rslt .= "<td><font color='red'>".$grow."%</td>";
          $rslt .= "</tr>";
      }
      return $rslt;
  }
?>
