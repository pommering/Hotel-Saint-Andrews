<!-- Room Number Field -->
<div class="form-group col-sm-6">
    {!! Form::label('room_number', 'Número do quarto:') !!}
    {!! Form::text('room_number', null, ['class' => 'form-control']) !!}
</div>

<!-- User Id Field -->
@can('manager')
    <div class="form-group col-sm-6">
        {!! Form::label('user_id', 'Usuário responsável:') !!}
        {!! Form::select('user_id', $userItems, null, ['class' => 'form-control custom-select']) !!}
    </div>
@endif

<!-- Start Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('start_date', 'Início:') !!}
    {!! Form::text('start_date', null, ['class' => 'form-control','id'=>'start_date']) !!}

</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#start_date').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: true,
            sideBySide: true
        })
    </script>
@endpush

<!-- End Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('end_date', 'Término:') !!}
    {!! Form::text('end_date', null, ['class' => 'form-control','id'=>'end_date']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#end_date').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: true,
            sideBySide: true
        })
    </script>
@endpush


<!-- Activitie Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('activitie_id', 'Tarefa feita:') !!}

    @foreach($activityItems as $key => $activityItem)
        <div class="position-relative d-flex align-items-center mb-2 p-2 rounded border border-primary text-primary checkbox-trigger" style="height: 38px">
            <div class="rounded border border-primary mr-2 checkbox-selected d-flex align-items-center justify-content-center" style="height: 16px; width:16px;">
                <i class="fas fa-check" style="font-size: 8px"></i>
            </div>

            {!! Form::checkbox('activityItem[]', $key, in_array($key, $tasks), ['class' => 'form-check-input d-none']) !!}
            {!! Form::label('manager', $activityItem, ['class' => 'form-check-label d-block ml-1 ']) !!}
        </div>
    @endforeach
</div>

@push('page_scripts')
<script type="text/javascript">

    function changeStateCheckbox() {
        document.querySelectorAll('.checkbox-trigger').forEach((e) => {
            if(e.querySelector('input').checked) {
                e.querySelector('.checkbox-selected').classList.add('border-light');
                e.classList.add('bg-primary');
            } else {
                e.querySelector('.checkbox-selected').classList.remove('border-light');
                e.classList.remove('bg-primary');
            }
        });
    }

    changeStateCheckbox();

    document.querySelectorAll('.checkbox-trigger').forEach((e) => {
        e.addEventListener("click", () => {
            e.querySelector('input').checked = !e.querySelector('input').checked;

            if(e.querySelector('input').checked) {
                e.querySelector('.checkbox-selected').classList.add('border-light');
                e.classList.add('bg-primary');
            } else {
                e.querySelector('.checkbox-selected').classList.remove('border-light');
                e.classList.remove('bg-primary');
            }
        })
    });

</script>
@endpush

