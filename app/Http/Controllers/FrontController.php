<?php

namespace App\Http\Controllers;

use App\Models\CompanyStatistic;
use App\Models\OurPrinciple;
use App\Models\Product;
use App\Models\OurTeam;
use App\Models\Testimonial; 
use App\Models\HeroSection;
use App\Models\CompanyAbout;
use App\Models\Appointment;
use App\Http\Requests\StoreAppointmentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FrontController extends Controller
{
    public function index()
    {
        $statistics = CompanyStatistic::take(4)->get();
        $principles = OurPrinciple::take(3)->get();
        $products = Product::take(3)->get();
        $teams = OurTeam::take(7)->get();
        $testimonials = Testimonial::take(5)->get();
        $hero_sections = HeroSection::orderByDesc('id')->take(1)->get();
        return view('front.index', compact('statistics', 'principles', 'products', 'teams', 'testimonials', 'hero_sections'));
    }

    public function team()
    {
        $teams = OurTeam::take(7)->get();
        $statistics = CompanyStatistic::take(4)->get();
        return view('front.team', compact('teams', 'statistics'));
    }

    public function about()
    {
        $statistics = CompanyStatistic::take(4)->get();
        $abouts = CompanyAbout::take(2)->get();
        return view('front.about', compact('statistics', 'abouts'));
    }

    public function appointment()
    {
        $testimonials = Testimonial::take(5)->get();
        $products = Product::take(3)->get();
        return view('front.appointment', compact('testimonials', 'products'));
    }

    public function appointment_store(StoreAppointmentRequest $request)
    {
        // Closure-based transaction
        DB::transaction(function () use ($request) {
            $validated = $request->validated();
            
            $newDataRecord = Appointment::create($validated);
        });

        return redirect()->route('front.index')->with('success', 'Appointment successfully created.');
    }
}
