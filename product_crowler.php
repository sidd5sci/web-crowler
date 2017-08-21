<style>
.red{color:red;}
.p-box{
	width:22%;
	height:300px;
	background: #efefef ;
	float:left;
	margin-left:1em;
	margin-top:1em;
	padding:10px;
	text-align:center;
	
}
.p-box img{
	margin-left:1em;

}
.form{
	width:100%;
	position:relative;top:2em;left:25em;
	margin:0px 0px 3em 0em;
}
.form input{
	width:30%;
	height:50px;
	border-radius:25px;
	box-shadow:0px 2px 10px #efefef;
}.form button{
	background:#ee4422;
	border:none;
	height:50px;
	width:100px;
	border-radius:10px;
	margin-left:20px;
	box-shadow:0px 2px 20px #ccc;
}
</style>
<?php




// This is our starting point. Change this to whatever URL you want.
//$start = "http://www.amazon.in/s/ref=nb_sb_noss_2?url=search-alias%3Daps&field-keywords=chairs";
$url   = "http://www.amazon.in/s/ref=nb_sb_noss_2?url=search-alias%3Daps&field-keywords=";
$search = false;
if($_POST){
	if(isset($_POST['query']) && $_POST['query']!='')
    $keys = $_POST['query'];
	$keys = str_replace(" ", "+", $keys);
	$url .= $keys;	
	$search = true;
}
// Our 2 global arrays containing our links to be crawled.
$already_crawled = array();
$crawling = array();

$titles = array();
$price_ = array();
$p_images = array();
$p_asin = array();
$p_ratings = array();
function get_products($url){
	global $titles,$price_,$p_image,$p_asin,$p_ratings;
	// Create a new instance of PHP's DOMDocument class.
	$doc = new DOMDocument();
	// Use file_get_contents() to download the page, pass the output of file_get_contents()
	// to PHP's DOMDocument class.
	@$doc->loadHTML(@file_get_contents($url));
	// Create an array of all of the links we find on the page.
	$headings = $doc->getElementsByTagName("h2");
	$asin = $doc->getElementsByTagName("li");
	$prices = $doc->getElementsByTagName("span");
	$images = $doc->getElementsByTagName("img");
	$ratings = $doc->getElementsByTagName("span");
	foreach($ratings as $rating){
	 if($class = $rating->getAttribute("class")){
		 if($class == "a-icon-alt")
			 $p_ratings[] = $rating->nodeValue;
		 
	 }
	 
	}
	foreach($asin as $a){
	 if($ASIN	=  $a->getAttribute("data-asin")){
		//echo $ASIN.'<br>';
		$p_asin[] = $ASIN;
		}
	}
	// Loop through all of the links we find.
	foreach ($headings as $heading) {
		if($head =  $heading->getAttribute("data-attribute")){
		$titles[] = $head;}
	}
	echo '<br><br>';
	foreach ($prices as $price){	
		$class = $price->getAttribute("class");
		$value = $price -> nodeValue;
		if($class == "a-size-base a-color-price s-price a-text-bold"){
		//echo $value.'<br>';
		$price_[] = $value;
		}
		
	}
	echo '<br><br>';
	foreach ($images as $image){	
		$src = $image->getAttribute("src");
		$gall = $image->getAttribute("srcset");
		$alt = $image->getAttribute("alt");
		//$value = $price -> nodeValue;
		//if($class == "a-size-base a-color-price s-price a-text-bold")
			if($alt == "Product Details")
			{//echo '<img src="'.$src.'"/><br>';
			$p_image[] = $src;
			}
			
			//echo '<p class="red">'.$gall.'</p><br>';
	}
}
	//print_r($titles);
	//echo count($titles);
	

get_products($url);?>


<div class="form">
	<form method="post" action="http://localhost/websites/test/php/product_crowler.php">
		<input type="text" name="query" placeholder="Search product"/>
		<button type="submit" name="submit" value="Search"/>Search</button>
	</form>
</div>

<div class="row">
<?php $i = 1; 
		if($search == true){
			while($i <= 20){
				echo '<a href="https://www.amazon.in/dp/'.$p_asin[$i].'/?tag=pasartworks-21" target="_blank"><div class="p-box">';
					echo '<h4 class="title">'.$titles[$i].'</h4>';
					echo '<img src="'.$p_image[$i].'" class="image"/>';
					echo '<div class="details">';
						echo '<span> Price:'.$price_[$i].'</span><br>';
						echo '<span> Ratings:'.$p_ratings[$i].'</span>';
					echo '</div>';
				echo '</div></a>';
			$i++;
		}
 }
 ?>
</div>

<!--

|geodes|
http://www.amazon.com/dp/{ASIN}/?tag={trackingId}
https://www.amazon.in/HMDX-Classic-Portable-Wireless-Speakers/dp/B007R6HUFI/ref=as_li_ss_tl? 
		pf_rd_m = A1VBAL9TL5WCBF& 
		pf_rd_s = 
		&pf_rd_r= 1D634H5ZY0Q0W1SN5ZYG
		&pf_rd_t=36701
		&pf_rd_p=97cf4a7f-7496-4fd3-86f0-28fe27604a2c
		&pf_rd_i=desktop
		&linkCode=ll1
		&tag=psartworks-21
		&linkId=f2970623f1c5e91c1a60fa25fcc0922c
https://www.amazon.in/illusion-Illusion-Black-Polo-T-Shirt/dp/B072SNBFR7/ref=as_li_ss_tl?
		s=electronics
		&ie=UTF8
		&qid=1503154153
		&sr=1-7
		&keywords=shirts
		&linkCode=ll1
		&tag=psartworks-21
		&linkId=68b0e60478b0bcc90d6ae5f3448de52b
https://www.amazon.in/Agate-Light-Table-Slices-set/dp/B0016KM78G/ref=as_li_ss_tl?_encoding=UTF8
		&portal-device-attributes=desktop
		&psc=1
		&refRID=081C5SE42ZV7CK3A5WV8
		&ref_=pd_ybh_a_48
		&linkCode=ll1
		&tag=psartworks-21
		&linkId=c00a4c81c35b49c7a4de49cf26be8e53
http://ws-in.amazon-adsystem.com/widgets/q?
		ServiceVersion=20070822&OneJS=1
		&Operation=GetAdHtml
		&MarketPlace=IN
		&source=ss
		&ref=as_ss_li_til
		&ad_type=product_link
		&tracking_id=psartworks-21
		&marketplace=amazon&region=IN
		&placement=B0016KM78G
		&asins=B0016KM78G
		&linkId=3cb05d5362e52269de9fe3ae51c13411
		&show_border=true&link_opens_in_new_window=true" -->