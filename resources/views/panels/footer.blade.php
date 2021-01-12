<!-- BEGIN: Footer-->
<footer
  class="{{$configData['mainFooterClass']}} @if($configData['isFooterFixed']=== true){{'footer-fixed'}}@else {{'footer-static'}} @endif @if($configData['isFooterDark']=== true) {{'footer-dark'}} @elseif($configData['isFooterDark']=== false) {{'footer-light'}} @else {{$configData['mainFooterColor']}} @endif">
  <div class="footer-copyright">
    <div class="container">
      <span>&copy; 2020 <a href="https://hoteratus.com/"
          target="_blank">Hoteratus</a> All rights reserved.
      </span>
      <span class="right hide-on-small-only">
        Design and Developed by <a href="https://hoteratus.com/">FHFSoft</a>
      </span>
    </div>
  </div>
</footer>

<!-- END: Footer-->
