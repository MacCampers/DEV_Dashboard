import { Component, OnInit } from '@angular/core';
import { WheatherService } from '../wheather-service.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-wheather-add-city',
  templateUrl: './wheather-add-city.component.html',
  styleUrls: ['./wheather-add-city.component.css']
})
export class WheatherAddCityComponent implements OnInit {

  newCity: string;
  failed: boolean;
  searching: boolean;

  constructor(public weatherService: WheatherService, private router: Router) { }

  ngOnInit() {
  }

  addCity() {
    this.searching = true;
    this.failed = false;
    const city = this.newCity;
    this.weatherService.getCurrentWeather(city).subscribe(x => {
      this.searching = false;
      this.router.navigate(['/city/' + city]);
    },
      error => {
        this.failed = true;
        this.searching = false;
      });
  }

}
