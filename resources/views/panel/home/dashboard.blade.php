 <div id="dashboard" class="col s12">


      <h3 ng-cloak ng-show="loadingDashboard" translate="loadingSummary"></h3>
        <div ng-cloak ng-show="loadingDashboard" class="progress">
                  <div class="indeterminate"></div>
         </div>
         <br>
<div ng-cloak ng-show="counters" class="wow fadeIn">
    <h2><span translate="there_are"></span> <strong>[[counters.lugares]] </strong><span translate="places_in"></span><strong> VAMOS. </strong></h2>

    <p>  <strong>[[counters.aprobados]]</strong> <span translate="panel_dash_summary_1"> </span><strong>[[counters.rechazados]] </strong> <span translate="panel_dash_summary_2" translate-values="{pendings: ' [[counters.pendientes]]'}"></span></p>

    <p> <span translate="exist"></span><strong> [[counters.conGeo]] </strong> <span translate="panel_dash_summary_3"></span><strong>[[counters.errorGeo]] </strong> <span translate="panel_dash_summary_4"></span></p>

    <p><span translate="exist"></span> <strong>[[counters.sinGeo]]</strong>  <span translate="panel_dash_summary_5"></span></p>

    <p><span translate="panel_dash_summary_6"></span><strong> [[counters.paises]] </strong> <span translate="countries"> </span>,  <strong>[[counters.ciudades]] </strong> <span translate="states"></span>, <span translate="and"></span>  <strong>[[counters.partido]]  </strong> <span translate="departments"></span>s </p>


    <div class="row valign-wrapper">
      <div class="col s7 right-align valign">
        <p><span translate="there_are"></span><strong> [[counters.evaluations]] </strong><span translate="panel_dash_summary_7"></span><strong> [[counters.placesEvaluation]] </strong><span translate="establishments"></span></p>
      </div>

      <div class="col s5 left-align valign">
        <a target="_self" href="panel/importer/full-eval-export/[[selectedLanguage]]" ng-click="" class="waves-effect waves-light btn-floating red"><i class="mdi-file-file-download left"></i></a>
      </div>
    </div>

 </div>

      <div class="section navigate row" ng-cloak ng-hide="loadingDashboard">


                 <input type="search" ng-model="search" placed="Escribir el valor por que queres filtrar">
                <h1 translate="panel_dash_table_title"> </h1>
               <table class="bordered striped responsive-table">
          <thead>
              <tr ng-cloak ng-hide="loadingPost">
                <th data-field="nombre"><span translate="district"></span>, <span translate="state"></span>, <span translate="country"></span></th>
                <th data-field="nombre_localidad" translate="places"></th>
            </tr>
          </thead>
          <tbody>

              <tr ng-cloak ng-hide="loadingPost" ng-repeat="city in ranking | filter:search">

                      <td>[[city.key]]</td>
                      <td>[[city.lugares]]</td>

              </tr>
          </tbody>
        </table>
         <h1 translate="panel_dash_table_title_2"> </h1>
               <table class="bordered striped responsive-table">
          <thead>
              <tr ng-cloak ng-hide="loadingPost">
                <th data-field="nombre"><span translate="district"></span>, <span translate="state"></span>, <span translate="country"></span></th>
                <th data-field="nombre_localidad" translate="places"></th>
            </tr>
          </thead>
          <tbody>

              <tr ng-cloak ng-hide="loadingPost" ng-repeat="city in nonGeo | filter:search">
                 <td>[[city.key]]</td>  <td>[[city.lugares]]</td>

              </tr>
          </tbody>
        </table>
        <h1 translate="panel_dash_table_title_3"></h1>
               <table class="bordered striped responsive-table">
          <thead>
              <tr ng-cloak ng-hide="loadingPost">

                <th data-field="nombre"><span translate="district"></span>, <span translate="state"></span>, <span translate="country"></span></th>
                <th data-field="nombre_localidad" translate="places"></th>
            </tr>
          </thead>
          <tbody>

              <tr ng-cloak ng-hide="loadingPost" ng-repeat="city in badGeo | filter:search">

                     <td>[[city.key]]</td> <td>[[city.lugares]]</td>

              </tr>
          </tbody>
        </table>

            </div>

      </div>


      </div>

    </div>
