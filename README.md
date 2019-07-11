# Stream-Proxy-Forwarder
This is simple forwarder for MP4 Links or other type of files.</br>
With this Script, you can ByPass limitations for certain providers who restrict their services only on 1 IP Address.</br>
You can stream that content via this Script and Share it to others.

# Usage
just change that parameters in code ($v variable)</br>
```
https://yourdomain.com/web_stream.php?q=PATH_TO_CONTENT
```

You can also Encrypt real path via 
```
Scramble("http://real_path_to_file..");
Descramble("%SCRAMBLED_HASH%"); (Just uncommend this function in web_stream.php)
```
