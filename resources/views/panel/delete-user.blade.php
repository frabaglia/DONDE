<div id="{!! $modal_id !!}" class="modal" ng-if="[[admin.id]] != {!! Auth::user()->id !!}">
    {!! Form::open(['url' => 'panel/delete-user', 'method' => 'post']) !!}
    <div class="modal-content">
        <div  class="row">
            <h5 class="center-align">Eliminar usuario</h5>
            <p class="center-align">
                <i class="material-icons red-text">priority_high</i>
                <span style="vertical-align: super;">
                    Está seguro de eliminar el usuario <span style="color: #e53935">{!! $content !!}</span> ?
                </span>
            </p>
        </div>
    </div>
    <div class="modal-footer">
        <div class="row">
            <div class="col l6">
                <a class="modal-action modal-close waves-effect waves-light btn grey" {{-- translate="cancel" --}}>Cancelar</a>
            </div>
            <div class="col l6">
                <button type="submit" class="waves-effect waves-light btn red" >Eliminar</button>
            </div>
        </div>
    </div>
    <input type="hidden" name="id"/ value="{!! $id !!}">
    {!! Form::close() !!}

</div>