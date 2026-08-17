@extends('layouts.app')

@section('title', 'Edit Time Log')


@section('content')


<div class="page-header">

    <div>

        <h1>Edit Time Log</h1>

        <p>
            Update time entry for:
            <strong>{{ $timeLog->task->title }}</strong>
        </p>

    </div>


    <div>

        <a href="{{ route('tasks.time-logs.index', $timeLog->task) }}"
           class="btn btn-secondary">

            <i class="bi bi-arrow-left"></i>

            Back

        </a>

    </div>

</div>




<form action="{{ route('time-logs.update', $timeLog) }}"
      method="POST">


    @csrf

    @method('PUT')




    {{-- Task --}}

    <div class="form-group">

        <label>
            Task
        </label>


        <input
            type="text"
            class="form-control"
            value="{{ $timeLog->task->title }}"
            readonly>

    </div>





    {{-- User --}}

    <div class="form-group">

        <label>
            Logged By
        </label>


        <input
            type="text"
            class="form-control"
            value="{{ $timeLog->user->name }}"
            readonly>

    </div>





    {{-- Minutes --}}

    <div class="form-group">


        <label>

            Minutes
            <span class="text-danger">*</span>

        </label>


        <input
            type="number"
            name="minutes"
            class="form-control"
            value="{{ old('minutes', $timeLog->minutes) }}"
            min="1"
            max="600">


        @error('minutes')

            <small class="text-danger">

                {{ $message }}

            </small>

        @enderror


    </div>





    {{-- Logged Date --}}

    <div class="form-group">


        <label>

            Logged Date
            <span class="text-danger">*</span>

        </label>


        <input
            type="date"
            name="logged_at"
            class="form-control"
            value="{{ old('logged_at', $timeLog->logged_at?->format('Y-m-d')) }}">



        @error('logged_at')

            <small class="text-danger">

                {{ $message }}

            </small>

        @enderror


    </div>





    {{-- Note --}}

    <div class="form-group">


        <label>

            Note

        </label>


        <textarea
            name="note"
            rows="4"
            class="form-control"
            placeholder="Update work details...">{{ old('note', $timeLog->note) }}</textarea>



        @error('note')

            <small class="text-danger">

                {{ $message }}

            </small>

        @enderror


    </div>





    {{-- Buttons --}}

    <div class="form-actions mt-4">


        <button
            type="submit"
            class="btn btn-success">


            <i class="bi bi-save"></i>

            Update Time Log


        </button>




        <a href="{{ route('tasks.time-logs.index', $timeLog->task) }}"
           class="btn btn-secondary">


            Cancel


        </a>


    </div>



</form>



@endsection