<?php

?>

<html>
<head></head>

<body>
	<form action="" method="GET">
         <input type="hidden" name="c" value="index">
         <input type="hidden" name="a" value="survey_list">
                       <div class="form-horizontal clearfix">
                           <div class="col-lg-12">
                               <div id="hidden-table-info_length" class="col-lg-4 col-md-6">
                                   <label class="d_label03">调查ID：</label>
                                   <div class="form-group col-lg-9 d_padr0">
                                       <input type="text" class="form-control input-lg" id="surveyid" name="sur_id" placeholder="id">
                                   </div>
                               </div>
                               <div id="hidden-table-info_length" class="col-lg-4 col-md-6">
                                   <label class="d_label03">调查标题：</label>
                                   <div class="form-group col-lg-9 d_padr0">
                                       <input type="text" class="form-control input-lg" id="surveytopic" name="title" placeholder="标题">
                                   </div>
                               </div>
                               
                           </div>
                           <div class="col-lg-12">
                               
                               <div id="hidden-table-info_length" class="col-lg-4  col-md-4">
                                   <div class="">
                                       <label class="d_label03">调查状态： </label>
                                       <div class="btn-group">
                                           <button data-toggle="dropdown" class="btn btn-white" type="button">进行</button>
                                           <button data-toggle="dropdown" class="btn btn-white dropdown-toggle" type="button"><span class="caret"></span></button>
                                           <ul role="menu" class="dropdown-menu">
                                               <li><a href="#" data-val='0'>进行</a></li>
                                               <li><a href="#" data-val='1'>暂停</a></li>
                                               <li><a href="#" data-val='2'>隐藏</a></li>
                                               <li><a href="#" data-val='3'>停止</a></li>
                                               <li><a href="#" data-val='cg'>存稿</a></li>
                                           </ul>
                                           <input type="hidden" name="status">
                                       </div>
                                   </div>
                               </div>
                               
                           </div>
                           <div class="col-lg-2 d_append">
                               <input type="submit" value="查 询" class="btn btn-primary input-lg col-lg-12">
                           </div>
                       </div>
                   </form>

</body>
</html>