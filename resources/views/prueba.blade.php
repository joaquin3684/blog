<?php echo asset('images/filename.png');?>
<!DOCTYPE html>
<html lang="en" ng-app="Mutual">
<body>
{{ Html::image('ifd/filename.png')}}
<img src="<?php echo asset('images/filename.png');?>"> </img>
<img src="ifd/filename.png">
{{ Html::image('images/1.png')}}
</body>
</html>