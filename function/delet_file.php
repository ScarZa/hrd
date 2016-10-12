<?php  
function fulldelete($location) {     
    if (is_dir($location)) {     
        $currdir = opendir($location);     
        while ($file = readdir($currdir)) {     
            if ($file  <> ".." && $file  <> ".") {     
                $fullfile = $location."/".$file;     
                if (is_dir($fullfile)) {     
                    if (!fulldelete($fullfile)) {     
                        return false;     
                    }     
                } else {     
                    if (!unlink($fullfile)) {     
                        return false;     
                    }     
                }     
            }     
        }     
        closedir($currdir);     
        if (! rmdir($location)) {     
            return false;     
        }     
    } else {     
        if (!unlink($location)) {     
            return false;     
        }     
    }     
    return true;     
}   

function remove_dir($dir)
{
  if(is_dir($dir))
  {
    $dir = (substr($dir, -1) != "/")? $dir."/":$dir;
    $openDir = opendir($dir);
    while($file = readdir($openDir))
    {
      if(!in_array($file, array(".", "..")))
      {
        if(!is_dir($dir.$file))
        {
          @unlink($dir.$file);
        }
        else
        {
          remove_dir($dir.$file);
        }
      }
    }
    closedir($openDir);
    @rmdir($dir);
  }
} 

 ?>  