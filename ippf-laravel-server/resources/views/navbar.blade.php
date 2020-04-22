<!-- NAV BAR DESKTOP/MOBILE-->
<nav>
  <div class="nav-wrapper">
    <a href="#!" class="brand-logo">
      <!-- WEBSITE LOGO -->
      <img class="logoTop" src="images/logo_blanco.svg">
      <!-- MOBILE BURGER BUTTON -->
      <a href="#" data-activates="mobile-demo" class="button-collapse">
        <i class="mdi-navigation-menu"></i>
      </a>
      <!-- DESKTOP NAVBAR -->
      <ul class="right hide-on-med-and-down">
        <li><a class="modal-trigger" href="#modal"><i class="mdi-action-info"></i></a></li>
        <li><a class="" href="#/localizar/all/listado"><i class="mdi-maps-place left"></i></a></li>
        <li><a class="" href="form"><i class="mdi-content-add-circle-outline"></i></a></li>
        <li><a class="" href="listado-paises"><i class="mdi-action-language"></i></a></li>
        <li>
          <select  name="language1" id="language1" ng-model="selectedLanguage" ng-change="changeLanguage()"  material-select watch>
            <option value="" disabled><span>LANG</span></option>
            <option value="en" name="en" ng-selected="[[selectedLanguage]]">EN</option>
            <option value="es" name="es" ng-selected="[[selectedLanguage]]">ES</option>
          </select>
        </li>
      </ul>

     <!-- POP NAVIGATION -->
     <ul ng-cloak ng-show="navigating"  class="left wow fadeIn nav-wrapper">
       <li><a href="" onclick="window.history.back();"><i class="mdi-navigation-chevron-left right"></i></a></li>
     </ul>

     <!-- MOBILE NAVBAR -->
     <ul class="side-nav" id="mobile-demo">
       <!-- LANG -->
       <li>
          <a href="javascript:void(0);">
            <i class="fa fa-language fa-2x" aria-hidden="true"></i>
            <div style="position: absolute;top: 0; left:30%; width: 25%;">
             <select name="language2" id="language2" ng-model="selectedLanguage" ng-change="changeLanguage()" material-select watch>
               <option value="en" ng-selected="[[selectedLanguage]]">EN</option>
               <option value="es" ng-selected="[[selectedLanguage]]" selected>ES</option>
             </select>
            </div>
         </a>
       </li>
       <!-- ABOUT -->
       <li>
         <a href="#/acerca">
           <i class="mdi-action-info left"></i><span translate="about"></span>
         </a>
       </li>
       <!-- GEOLOCALIZATION SHOW EVERY PLACE -->
       <li>
         <a href="#/localizar/all/listado">
           <i class="mdi-maps-place left"></i>
           <span translate="closer"></span>
         </a>
       </li>
       <!-- FORM SUGGEST -->
       <li>
         <a href="form">
           <i class="mdi-content-add-circle-outline left"></i><span translate="seggest"></span>
         </a>
      </li>
      <!-- COUNTRY LIST -->
      <li>
        <a href="listado-paises">
          <i class="mdi-action-language left"></i>
          <span translate="list"></span>
        </a>
      </li>
    </ul>
  </div>
</nav>
<!-- END NAV BAR DESKTOP/MOBILE -->
