<?php
declare(strict_types=1);
header('Content-Type: application/json; charset=utf-8');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); echo json_encode(['success'=>false,'message'=>'Method not allowed.']); exit; }
if (!empty($_POST['website'] ?? '')) { http_response_code(400); echo json_encode(['success'=>false,'message'=>'Invalid submission.']); exit; }
$required=['title','type','location','price','beds','baths','owner_name','phone','email'];
foreach($required as $field){ if(trim((string)($_POST[$field] ?? ''))===''){ http_response_code(422); echo json_encode(['success'=>false,'message'=>'Please complete all required fields.']); exit; }}
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) { http_response_code(422); echo json_encode(['success'=>false,'message'=>'Please provide a valid email address.']); exit; }
if (empty($_POST['consent'])) { http_response_code(422); echo json_encode(['success'=>false,'message'=>'Please confirm that you have the right to list this property.']); exit; }
$allowed=['image/jpeg'=>'jpg','image/png'=>'png','image/webp'=>'webp'];
$files=$_FILES['photos'] ?? null;
if (!$files || !isset($files['name']) || !is_array($files['name'])) { http_response_code(422); echo json_encode(['success'=>false,'message'=>'Please upload at least one property photo.']); exit; }
$count=count($files['name']); if($count<1 || $count>20){http_response_code(422);echo json_encode(['success'=>false,'message'=>'Please upload between 1 and 20 photos.']);exit;}
$uploadDir=__DIR__.'/../uploads/properties/';
if(!is_dir($uploadDir) && !mkdir($uploadDir,0755,true)){http_response_code(500);echo json_encode(['success'=>false,'message'=>'Upload storage is unavailable.']);exit;}
$stored=[];
$finfo=new finfo(FILEINFO_MIME_TYPE);
for($i=0;$i<$count;$i++){
  if(($files['error'][$i]??UPLOAD_ERR_NO_FILE)!==UPLOAD_ERR_OK){http_response_code(422);echo json_encode(['success'=>false,'message'=>'One of the uploaded photos could not be received.']);exit;}
  if(($files['size'][$i]??0)>10*1024*1024){http_response_code(422);echo json_encode(['success'=>false,'message'=>'Each photo must be 10 MB or smaller.']);exit;}
  $mime=$finfo->file($files['tmp_name'][$i]); if(!isset($allowed[$mime])){http_response_code(422);echo json_encode(['success'=>false,'message'=>'Only JPG, PNG and WebP photos are allowed.']);exit;}
  $name=bin2hex(random_bytes(16)).'.'.$allowed[$mime];
  if(!move_uploaded_file($files['tmp_name'][$i],$uploadDir.$name)){http_response_code(500);echo json_encode(['success'=>false,'message'=>'A photo could not be stored.']);exit;}
  $stored[]='uploads/properties/'.$name;
}
$listingId='BK-'.date('YmdHis').'-'.bin2hex(random_bytes(3));
$record=['id'=>$listingId,'title'=>trim($_POST['title']),'type'=>trim($_POST['type']),'location'=>trim($_POST['location']),'price'=>(float)$_POST['price'],'beds'=>(int)$_POST['beds'],'baths'=>(int)$_POST['baths'],'area'=>trim($_POST['area']??''),'description'=>trim($_POST['description']??''),'owner_name'=>trim($_POST['owner_name']),'phone'=>trim($_POST['phone']),'email'=>trim($_POST['email']),'cover_photo_index'=>(int)($_POST['cover_photo_index']??0),'photos'=>$stored,'status'=>'pending_review','created_at'=>date(DATE_ATOM)];
// Backend-ready handoff: persist $record to MySQL/PDO or your chosen API here, then trigger SMTP notification.
$pendingDir=__DIR__.'/../storage/pending-listings/'; if(!is_dir($pendingDir))mkdir($pendingDir,0755,true); file_put_contents($pendingDir.$listingId.'.json',json_encode($record,JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES),LOCK_EX);
echo json_encode(['success'=>true,'listing_id'=>$listingId,'message'=>'Your property listing and photos were received. It is now ready for review.']);
