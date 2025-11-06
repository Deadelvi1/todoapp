@extends('layouts.app')

@section('title', 'TodoTimer - Study Time Management')

@section('content')
<div style="text-align: center; padding: 60px 20px;">
    <h1 style="font-size: 2.5em; margin-bottom: 20px;">Welcome to TodoTimer</h1>
    <p style="font-size: 1.2em; color: #666; margin-bottom: 40px;">
        Track your study time, manage goals, and boost your productivity
    </p>

    <div style="max-width: 800px; margin: 0 auto;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 40px;">
            <div class="card" style="text-align: left; padding: 20px;">
                <h3>📚 Track Study Time</h3>
                <p>Record your study sessions and monitor your progress towards your learning goals.</p>
            </div>
            <div class="card" style="text-align: left; padding: 20px;">
                <h3>🎯 Set Study Goals</h3>
                <p>Create specific study goals and track your achievement progress over time.</p>
            </div>
            <div class="card" style="text-align: left; padding: 20px;">
                <h3>✅ Manage Tasks</h3>
                <p>Keep track of your todos and stay organized with your study schedule.</p>
            </div>
        </div>

        <div style="margin-top: 40px;">
            @if(session()->has('user'))
                <a href="{{ route('dashboard') }}" class="btn" style="font-size: 1.2em; padding: 12px 30px;">Go to Dashboard</a>
            @else
                <a href="{{ route('register') }}" class="btn" style="font-size: 1.2em; padding: 12px 30px; margin-right: 20px;">Get Started</a>
                <a href="{{ route('login') }}" style="color: #007bff; text-decoration: none;">Already have an account? Login</a>
            @endif
        </div>
    </div>
</div>
@endsection