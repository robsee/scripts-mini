#!/usr/local/bin/Resource/www/cgi-bin/php
<?php echo "<?xml version='1.0' encoding='UTF8' ?>"; ?>
<rss version="2.0">

<!--
#
#   http://code.google.com/media-translate/
#   Copyright (C) 2010  Serge A. Timchenko
#
#   This program is free software: you can redistribute it and/or modify
#   it under the terms of the GNU General Public License as published by
#   the Free Software Foundation, either version 3 of the License, or
#   (at your option) any later version.
#
#   This program is distributed in the hope that it will be useful,
#   but WITHOUT ANY WARRANTY; without even the implied warranty of
#   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#   GNU General Public License for more details.
#
#   You should have received a copy of the GNU General Public License
#   along with this program. If not, see <http://www.gnu.org/licenses/>.
#
-->

<script>
  translate_base_url  = "http://127.0.0.1/cgi-bin/translate?";
  cgiconf = readStringFromFile("/usr/local/etc/translate/etc/cgi.conf");
  if(cgiconf != null)
  {
    value = getStringArrayAt(cgiconf, 0);
    if(value != null &amp;&amp; value != "")
    {
      translate_base_url = value;
      print("cgi.conf=",value);
    }
  }

  storagePath             = getStoragePath("tmp");
  storagePath_stream      = storagePath + "stream.dat";
  storagePath_playlist    = storagePath + "playlist.dat";

  error_info          = "";
</script>

<onEnter>
    startitem = "middle";

  setRefreshTime(1);
</onEnter>

<onRefresh>
  setRefreshTime(-1);
  itemCount = getPageInfo("itemCount");
</onRefresh>

<mediaDisplay name="onePartView"
	sideLeftWidthPC="0"
	sideRightWidthPC="0"

	headerImageWidthPC="0"
	selectMenuOnRight="no"
	autoSelectMenu="no"
	autoSelectItem="no"
	itemImageHeightPC="0"
	itemImageWidthPC="0"
	itemXPC="8"
	itemYPC="25"
	itemWidthPC="48"
	itemHeightPC="8"
	capXPC="8"
	capYPC="25"
	capWidthPC="48"
	capHeightPC="64"
	itemBackgroundColor="0:0:0"
	itemPerPage="8"
  itemGap="0"
	bottomYPC="90"
	backgroundColor="0:0:0"
	showHeader="no"
	showDefaultInfo="no"
	imageFocus=""
	sliding="no" idleImageXPC="5" idleImageYPC="5" idleImageWidthPC="8" idleImageHeightPC="10"
>

  	<text align="center" offsetXPC="0" offsetYPC="0" widthPC="100" heightPC="20" fontSize="30" backgroundColor="10:105:150" foregroundColor="100:200:255">
		  <script>getPageInfo("pageTitle");</script>
		</text>

		<image offsetXPC=5 offsetYPC=2 widthPC=20 heightPC=16>
		  <script>channelImage;</script>
		</image>

  	<text redraw="yes" offsetXPC="82" offsetYPC="12" widthPC="13" heightPC="6" fontSize="20" backgroundColor="10:105:150" foregroundColor="60:160:205">
		  <script>sprintf("%s / ", focus-(-1))+itemCount;</script>
		</text>
		<image  redraw="yes" offsetXPC=60 offsetYPC=35 widthPC=30 heightPC=30>
  ../etc/translate/rss/image/radio_online.jpg
		</image>
<!--
		<text align="justify" redraw="yes"
          lines="14" fontSize=14
		      offsetXPC=55 offsetYPC=25 widthPC=40 heightPC=60
		      backgroundColor=10:80:120 foregroundColor=200:200:200>
			<script>print(annotation); annotation;</script>
		</text>

		<text align="center" redraw="yes" offsetXPC=55 offsetYPC=85 widthPC=40 heightPC=5 fontSize=13 backgroundColor=10:80:120 foregroundColor=0:0:0>
			<script>print(location); location;</script>
		</text>

		<text align="center" redraw="yes" offsetXPC=55 offsetYPC=90 widthPC=40 heightPC=5 fontSize=13 backgroundColor=0:0:0 foregroundColor=200:80:80>
			<script>if(streamurl==""||streamurl==null) "WARNING! No stream url."; else "";</script>
		</text>
-->
		<idleImage> image/POPUP_LOADING_01.png </idleImage>
		<idleImage> image/POPUP_LOADING_02.png </idleImage>
		<idleImage> image/POPUP_LOADING_03.png </idleImage>
		<idleImage> image/POPUP_LOADING_04.png </idleImage>
		<idleImage> image/POPUP_LOADING_05.png </idleImage>
		<idleImage> image/POPUP_LOADING_06.png </idleImage>
		<idleImage> image/POPUP_LOADING_07.png </idleImage>
		<idleImage> image/POPUP_LOADING_08.png </idleImage>

		<itemDisplay>
			<text align="left" lines="1" offsetXPC=0 offsetYPC=0 widthPC=100 heightPC=100>
				<script>
					idx = getQueryItemIndex();
					focus = getFocusItemIndex();
					if(focus==idx)
					{
					  location = getItemInfo(idx, "location");
					  annotation = getItemInfo(idx, "annotation");
					  if(annotation == "" || annotation == null)
					    annotation = getItemInfo(idx, "stream_genre");
                        streamurl = getItemInfo(idx, "stream_u");
					}
					getItemInfo(idx, "title");
				</script>
				<fontSize>
  				<script>
  					idx = getQueryItemIndex();
  					focus = getFocusItemIndex();
  			    if(focus==idx) "16"; else "14";
  				</script>
				</fontSize>
			  <backgroundColor>
  				<script>
  					idx = getQueryItemIndex();
  					focus = getFocusItemIndex();
  			    if(focus==idx) "10:80:120"; else "-1:-1:-1";
  				</script>
			  </backgroundColor>
			  <foregroundColor>
  				<script>
  					idx = getQueryItemIndex();
  					focus = getFocusItemIndex();
  			    if(focus==idx) "255:255:255"; else "140:140:140";
  				</script>
			  </foregroundColor>
			</text>

		</itemDisplay>

  <onUserInput>
    <script>
      ret = "false";
      userInput = currentUserInput();
      majorContext = getPageInfo("majorContext");

      print("*** majorContext=",majorContext);
      print("*** userInput=",userInput);

      if(userInput == "enter" || userInput == "ENTR")
      {
        showIdle();
        focus = getFocusItemIndex();
        stream_u = "http://127.0.0.1/cgi-bin/scripts/tv/php/german_link.php?file=" + getItemInfo(focus, "stream_u");
        stream_url = getUrl(stream_u);

        request_title = getItemInfo(focus, "title");
        request_url = getItemInfo(focus, "location");
        request_options = getItemInfo(focus, "options");
        request_image = getItemInfo(focus, "image");

        stream_title = getItemInfo(focus, "stream_title");
        stream_type = getItemInfo(focus, "stream_type");
        stream_protocol = getItemInfo(focus, "stream_protocol");
        stream_soft = getItemInfo(focus, "stream_soft");
        stream_class = getItemInfo(focus, "stream_class");
        stream_server = getItemInfo(focus, "stream_server");
        stream_status_url = "";
        stream_current_song = "";
        stream_genre = getItemInfo(focus, "stream_genre");
        stream_bitrate = getItemInfo(focus, "stream_bitrate");
        playlist_autoplay = getItemInfo(focus, "autoplay");

        if(playlist_autoplay == "" || playlist_autoplay == null)
          playlist_autoplay = 1;

        if(stream_class == "" || stream_class == null)
          stream_class = "unknown";

        if(stream_url == "" || stream_url == null)
          stream_url = request_url;

        if(stream_server != "" &amp;&amp; stream_server != null)
          stream_status_url = translate_base_url + "status," + urlEncode(stream_server) + "," + urlEncode(stream_url);

        if(stream_title == "" || stream_title == null)
          stream_title = request_title;

        if(stream_url != "" &amp;&amp; stream_url != null)
        {
          if(stream_protocol == "file" || (stream_protocol == "http" &amp;&amp; stream_soft != "shoutcast"))
          {
            url = stream_url;
          }
          else
          {
            if(stream_type != null &amp;&amp; stream_type != "")
            {
              request_options = "Content-type:"+stream_type+";"+request_options;
            }
            url = translate_base_url + "stream," + request_options + "," + urlEncode(stream_url);
          }

          executeScript(stream_class+"Dispatcher");
        }

        cancelIdle();
        ret = "true";
      }
      else if(userInput == "right" || userInput == "R")
      {
        ret = "true";
      }
      else if (userInput == "pagedown" || userInput == "pageup" || userInput == "PD" || userInput == "PG")
      {
        itemSize = getPageInfo("itemCount");
        idx = Integer(getFocusItemIndex());
        if (userInput == "pagedown")
        {
          idx -= -8;
          if(idx &gt;= itemSize)
            idx = itemSize-1;
        }
        else
        {
          idx -= 8;
          if(idx &lt; 0)
            idx = 0;
        }
        setFocusItemIndex(idx);
        setItemFocus(idx);
        redrawDisplay();
        ret = "true";
      }

      ret;
    </script>
  </onUserInput>

	</mediaDisplay>

	<item_template>
		<mediaDisplay  name="threePartsView" idleImageXPC="5" idleImageYPC="5" idleImageWidthPC="8" idleImageHeightPC="10">
		<idleImage> image/POPUP_LOADING_01.png </idleImage>
		<idleImage> image/POPUP_LOADING_02.png </idleImage>
		<idleImage> image/POPUP_LOADING_03.png </idleImage>
		<idleImage> image/POPUP_LOADING_04.png </idleImage>
		<idleImage> image/POPUP_LOADING_05.png </idleImage>
		<idleImage> image/POPUP_LOADING_06.png </idleImage>
		<idleImage> image/POPUP_LOADING_07.png </idleImage>
		<idleImage> image/POPUP_LOADING_08.png </idleImage>
		</mediaDisplay>
	</item_template>

  <videoDispatcher>
    streamArray = null;
    streamArray = pushBackStringArray(streamArray, request_url);
    streamArray = pushBackStringArray(streamArray, request_options);
    streamArray = pushBackStringArray(streamArray, stream_url);
    streamArray = pushBackStringArray(streamArray, url);
    streamArray = pushBackStringArray(streamArray, stream_type);
    streamArray = pushBackStringArray(streamArray, stream_title);
    streamArray = pushBackStringArray(streamArray, "1");
    writeStringToFile(storagePath_stream, streamArray);
    doModalRss("rss_file://../etc/translate/rss/xspf/videoRenderer.rss");
  </videoDispatcher>

  <audioDispatcher>
    streamArray = null;
    streamArray = pushBackStringArray(streamArray, request_url);
    streamArray = pushBackStringArray(streamArray, request_options);
    streamArray = pushBackStringArray(streamArray, stream_url);
    streamArray = pushBackStringArray(streamArray, url);
    streamArray = pushBackStringArray(streamArray, stream_type);
    streamArray = pushBackStringArray(streamArray, stream_status_url);
    streamArray = pushBackStringArray(streamArray, stream_current_song);
    streamArray = pushBackStringArray(streamArray, stream_genre);
    streamArray = pushBackStringArray(streamArray, stream_bitrate);
    streamArray = pushBackStringArray(streamArray, stream_title);
    streamArray = pushBackStringArray(streamArray, request_image);
    streamArray = pushBackStringArray(streamArray, "1");
    writeStringToFile(storagePath_stream, streamArray);
    doModalRss("rss_file://../etc/translate/rss/xspf/audioRenderer.rss");
  </audioDispatcher>

  <playlistDispatcher>
    streamArray = null;
    streamArray = pushBackStringArray(streamArray, stream_url);
    streamArray = pushBackStringArray(streamArray, stream_url);
    streamArray = pushBackStringArray(streamArray, "");
    streamArray = pushBackStringArray(streamArray, "");
    streamArray = pushBackStringArray(streamArray, "playlist");
    streamArray = pushBackStringArray(streamArray, playlist_autoplay);
    writeStringToFile(storagePath_playlist, streamArray);
    doModalRss("rss_file://../etc/translate/rss/xspf/xspfBrowser.rss");
  </playlistDispatcher>

  <rssDispatcher>
    streamArray = null;
    streamArray = pushBackStringArray(streamArray, stream_url);
    streamArray = pushBackStringArray(streamArray, stream_url);
    streamArray = pushBackStringArray(streamArray, "");
    streamArray = pushBackStringArray(streamArray, "");
    writeStringToFile(storagePath_stream, streamArray);
    doModalRss("rss_file://../etc/translate/rss/xspf/rss_mediaFeed.rss");
  </rssDispatcher>

  <unknownDispatcher>
    info_url    = translate_base_url + "info," + request_options + "," + urlEncode(request_url);
    error_info  = "";

    res = loadXMLFile(info_url);

    if (res != null)
    {
      error = getXMLElementCount("info","error");

      if(error != 0)
      {
  	    value = getXMLText("info","error");
  	    if(value != null)
  	    {
  	     error_info = value;
  	    }
      }
      else
      {
  	    value = getXMLAttribute("info","stream","url");
  	    if(value != null)
  	     stream_url = value;

  	    value = getXMLAttribute("info","stream","type");
  	    if(value != null)
  	     stream_type = value;

  	    value = getXMLAttribute("info","stream","class");
  	    if(value != null)
  	     stream_class = value;

  	    value = getXMLAttribute("info","stream","protocol");
  	    if(value != null)
  	     stream_protocol = value;

  	    value = getXMLAttribute("info","stream","server");
  	    if(value != null)
  	     stream_soft = value;

        stream_status_url = "";

  	    value = getXMLAttribute("info","stream","server_url");
  	    if(value != null)
  	    {
  	     stream_server_url = value;
  	     if((stream_soft == "icecast" || stream_soft == "shoutcast") &amp;&amp; stream_server_url!="")
  	     {
    	      stream_status_url = translate_base_url+"status,"+urlEncode(stream_server_url)+","+urlEncode(stream_url);
    	   }
  	    }

        value = getXMLText("info","status","stream-title");
  	    if(value != null)
  	     stream_title = value;

        stream_current_song = "";
  	    value = getXMLText("info","status","current-song");
  	    if(value != null)
    		  stream_current_song = value;

  	    value = getXMLText("info","status","stream-genre");
  	    if(value != null)
  	      stream_genre = value;

  	    value = getXMLText("info","status","stream-bitrate");
  	    if(value != null)
  	      stream_bitrate = value;

        options = "";

        if(stream_type != "")
          options = "Content-type:"+stream_type;

        if(options == "")
          options = stream_options;
        else
          options = options + ";" + stream_options;

  	    stream_translate_url = translate_base_url + "stream," + options + "," + urlEncode(stream_url);

  	    url = null;

  	    if(stream_class == "video" || stream_class == "audio")
    	  {
          if(stream_protocol == "file" || (stream_protocol == "http" &amp;&amp; stream_soft != "shoutcast"))
    	      url = stream_url;
    	    else
    	      url = stream_translate_url;
    	  }
    	  else
    	  {
  	      url = stream_url;
    	  }

    	  if(url != null)
    	  {
          if(stream_class == "audio" || stream_class == "video" || stream_class == "playlist" || stream_class == "rss")
          {
            executeScript(stream_class+"Dispatcher");
          }
          else
          {
            error_info = "Unsupported media type: " + stream_type;
          }
  	    }
  	    else
  	    {
          error_info = "Empty stream url!";
  	    }
      }
    }
    else
    {
      error_info = "CGI translate module failed!";
    }
    print("error_info=",error_info);
  </unknownDispatcher>

<script>
    channelImage = "";
  </script><channel>
  <title>German radio stations</title>
<?php
function str_between($string, $start, $end){
	$string = " ".$string; $ini = strpos($string,$start);
	if ($ini == 0) return ""; $ini += strlen($start); $len = strpos($string,$end,$ini) - $ini;
	return substr($string,$ini,$len);
}
//<td class="home">
$link="http://www.listenlive.eu/germany.html";
$html=file_get_contents($link);
$html=str_between($html,'<div class="thetable3">','</table>');
$videos = explode('<tr>', $html);
unset($videos[0]);
$videos = array_values($videos);
foreach($videos as $video) {
  $title=str_between($video,"<b>","</b>");
  $title = preg_replace("/(<\/?)([^>]*>)/e","",$title);
  $t1=explode("<td>",$video);
  $l=$t1[4];
  $t1=explode('href="',$l);
  if ($t1[2] == "") {
    $t2=explode('"',$t1[1]);
  } else {
    $t2=explode('"',$t1[2]);
  }
  $link=$t2[0];
  if ((strpos($link,"javascript") === false) && ($link <> "")){

  echo '
  <item>
  <title>'.$title.'</title>
  <location>'.$link.'</location>
  <stream_u>'.$link.'</stream_u>
  <stream_class>audio</stream_class>
  </item>
  ';

}
}
?>
</channel>
</rss>
