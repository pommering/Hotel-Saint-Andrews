<!-- Room Number Field -->
<div class="form-group col-sm-6">
    {!! Form::label('room_number', 'Número do quarto:') !!}
    {!! Form::text('room_number', null, ['class' => 'form-control']) !!}
</div>

<!-- User Id Field -->
@can('manager')
    <div class="form-group col-sm-6">
        {!! Form::label('user_id', 'Faxineira:') !!}
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

<style>
    #time_execution::placeholder {
        color: white;
    }
</style>


<!-- Activitie Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('activitie_id', 'Tarefa feita:') !!}

    @foreach($activityItems as $key => $activityItem)

        <div class="position-relative mb-2 p-2 rounded border border-primary text-primary d-flex align-items-center" style="height: 38px">
            <div class="checkbox-trigger d-flex align-items-center flex-grow-1 w-100">
                <div class="rounded border border-primary mr-2 checkbox-selected d-flex align-items-center justify-content-center" style="height: 16px; width:16px;">
                    <i class="fas fa-check" style="font-size: 8px"></i>
                </div>

                {!! Form::checkbox('activityItem[task][]', $key, in_array($key, $tasks['id']), ['class' => 'form-check-input d-none', $activityItem['mandatory'] ? 'readonly' : '']) !!}
                {!! Form::label('manager', $activityItem['assignment'], ['class' => 'form-check-label d-block ml-1 ']) !!}
            </div>
            <div class="d-flex align-items-center justify-content-center flex-grow-1 time">
                {!! Form::text('activityItem[timeTask][]', in_array($key, $tasks['id']) ? $tasks['time'][$key] : '00:00:00', ['class' => 'form-control d-none times','id'=>'time_execution', 'placeholder' => 'Tempo decorrido', 'style'=> 'border:0;margin:0;background: transparent; color:white; border-bottom: 1px solid #ccc; padding:5px 5px; height: auto; border-radius: 0; width: auto ']) !!}
            </div>
        </div>
    @endforeach
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('.times').datetimepicker({
            format: 'HH:mm:ss',
            useCurrent: true,
            sideBySide: true
        })
    </script>
@endpush


@push('page_scripts')
<script type="text/javascript">

    function changeStateCheckbox() {
        document.querySelectorAll('.checkbox-trigger').forEach((e) => {
            const inputCheckBox = e.querySelector('input');
            if(inputCheckBox.checked || inputCheckBox.readOnly) {
                inputCheckBox.checked = true;
                e.querySelector('.checkbox-selected').classList.remove('border-primary');
                e.querySelector('.checkbox-selected .fas').classList.remove('d-none');
                e.parentElement.classList.add('bg-primary');
                e.parentElement.querySelector('.time').classList.remove('d-none');
                e.parentElement.querySelector('.time input').classList.remove('d-none');
                e.parentElement.querySelector('.time input').disabled = false;
            } else {
                inputCheckBox.checked = false;
                e.querySelector('.checkbox-selected').classList.add('border-primary');
                e.querySelector('.checkbox-selected .fas').classList.add('d-none');
                e.parentElement.classList.remove('bg-primary');
                e.parentElement.querySelector('.time').classList.add('d-none');
                e.parentElement.querySelector('.time input').classList.add('d-none');
                e.parentElement.querySelector('.time input').disabled = true;
            }
        });
    }

    changeStateCheckbox();


    document.querySelectorAll('.checkbox-trigger').forEach((e) => {
        e.addEventListener("click", () => {

            if(!e.querySelector('input').readOnly) {
                e.querySelector('input').checked = !e.querySelector('input').checked;
            } else {
                alert("Tarefa obrigatória")
            }

            if(e.querySelector('input').checked) {
                e.querySelector('.checkbox-selected').classList.remove('border-primary');
                e.querySelector('.checkbox-selected .fas').classList.remove('d-none');
                e.parentElement.classList.add('bg-primary');
                e.parentElement.querySelector('.time').classList.remove('d-none');
                e.parentElement.querySelector('.time').classList.remove('d-none');
                e.parentElement.querySelector('.time input').classList.remove('d-none');
                e.parentElement.querySelector('.time input').disabled = false;
            } else {
                e.querySelector('.checkbox-selected').classList.add('border-primary');
                e.querySelector('.checkbox-selected .fas').classList.add('d-none');
                e.parentElement.classList.remove('bg-primary');
                e.parentElement.querySelector('.time').classList.add('d-none');
                e.parentElement.querySelector('.time input').classList.add('d-none');
                e.parentElement.querySelector('.time input').disabled = true;
            }
        })
    });

</script>
@endpush

