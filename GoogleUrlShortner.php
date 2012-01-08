<?php
class GoogleUrlShortner{
//get yout own key from google
   public  $key = "";
   public  $googleLink = "https://www.googleapis.com/urlshortener/v1/url";
   private function sendReceive($data = null,$destinationLink){
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $destinationLink);
      curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
      curl_setopt($ch, CURLOPT_FAILONERROR, true);
      if($data != null){
           curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
           curl_setopt($ch, CURLOPT_POST, 1);
           curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
      }
      curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
      curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
      $err = curl_error($ch);
     // $response = curl_exec($ch);
      curl_close($ch);
      return json_decode($response,true);
   }
   public function shorten($url){
      $link = "$this->googleLink?key=$this->key";
      $this->UrlValidator($url);
      $data = '{"longUrl": "'.$url.'"}';
      echo $link;
      return $this->sendReceive($data,$link);
    }
    public function expandUrl($shortUrl){
        $link = "$this->googleLink?key=$this->key&shortUrl=$shortUrl";
        return $this->sendReceive(null,$link);
    }
    public function analytics($url){
       $link = "$this->googleLink?key=$this->key&shortUrl=$shortUrl&projection=FULL";
       return $this->sendReceive(null,$link);
    }
}
//example usage
$shortner = new GoogleUrlShortner();
$result = $shortner->shorten("http://kiranruth.com");
$shortUrl = $result['id'];
$result = $shortner->expandUrl($shortUrl);
$analytics = $shortner->analytics($shortUrl);
?>