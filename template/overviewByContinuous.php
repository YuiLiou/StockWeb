<?php
  require_once('db.php');
  echo "\"";
  /*********************************************************************************/
  /* 日期下拉式選單跳轉的部份
  /*********************************************************************************/
  echo "  <input type='hidden' name='type' value='season'>";
  echo "</form>";
  /*********************************************************************************/
  ///////////////////////////////////// 季節選單 /////////////////////////////////////
  $sql = "select year, season ".
         "from eps ".
         "group by year, season ".
         "order by year desc, season desc ";
  $result = $conn->query($sql);
  
  echo "<form action='index.php' method='POST'>";  
  echo "    <select id='selSeason' name='season' onchange='this.form.submit()'>";  
  foreach ($result as $row)
  {
      $selSeason = $row['year'].$row['season'];
      if (empty($_POST['season']))
      {
          $_POST['season'] = $selSeason; // 預設
      }      
      if ($_POST['season'] == $selSeason) // 顯示被選擇的季節
          echo "<option selected='selected' value='".$selSeason."'>".$selSeason."</option>";
      else
          echo "<option value='".$selSeason."'>".$selSeason."</option>";
  }
  echo "  </select>";
  echo "  <input type='hidden' name='type' value='continuous'>";
  echo "</form>";

  ///////////////////////////////////// 公司列表 /////////////////////////////////////

  $sql = "select m.company, m.code, e.eps ".
         "from _eps e, company_map m ".
         "where e.code in ('".$codes."') ".
         "and e.code = m.code ".
         "order by e.code asc, e.year desc, e.season desc ";

  $result = $conn->query($sql);
  $_code = "";
  $_company = "";
  $_sense = 0;
  $_eps = 0;
  $skip = false;
  $code_ary = array();
  $company_ary = array();
  $sense_ary = array();
  foreach ($result as $row)
  {
      ///////////////////////新的公司///////////////////////
      if ($_code != $row['code'])
      {
          if ($_code != "")
          {
              array_push($code_ary, $_code);
              array_push($company_ary, $_company);
              array_push($sense_ary, $_sense);
          }
          $_company = $row['company'];
          $_code = $row['code'];          
          $_sense = 0;      
          $_eps = $row['eps'];    
          $skip = false;
          continue;
      }
      ///////////////////////是否換下一間///////////////////////
      if ($skip == true)
      {
          continue;
      }
      ///////////////////////連續成長或衰退///////////////////////
      if ($_sense == 0)
      {
          if ($_eps >= $row['eps'])
          {
              $_sense = 1;
          }
          else
          {
              $_sense = -1;
          }
      }
      else
      {
          if ($_sense > 0 and $_eps >= $row['eps']) 
          {  
              $_sense += 1;
          }
          else if ($_sense < 0 and $_eps < $row['eps']) 
          { 
              $_sense -= 1;
          }
          else
          {
              $skip = true;
          }
      }
      ///////////////////////紀錄前筆eps///////////////////////
      $_eps = $row['eps'];
  }
  array_push($code_ary, $_code);
  array_push($sense_ary, $_sense);
  array_push($company_ary, $_company);
  for ($i=0; $i<count($code_ary); $i++)
  {
      echo "<a href=finance.php?company=".$code_ary[$i].">";
      echo $company_ary[$i].'('.$code_ary[$i].')';
      if ($sense_ary[$i] > 0)       
          echo " <div style='color:red;'>EPS連續成長".$sense_ary[$i].'季</div><br>';
      else
          echo " <div style='color:green;'>EPS連續衰退".-1*$sense_ary[$i].'季</div><br>';
      echo "</a>";
  } 
  echo "\""; 
  $result->close();
?>
