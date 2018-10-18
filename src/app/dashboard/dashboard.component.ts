import { Component, OnInit } from '@angular/core';
import { AuthService } from '../authentification/services/auth.service';
import { Router } from '@angular/router';
import { WeatherService } from '../weather/weather-service.service';

@Component({
  selector: 'app-dashboard',
  templateUrl: './dashboard.component.html',
  styleUrls: ['./dashboard.component.css']
})
export class DashboardComponent implements OnInit {

  constructor(public authService: AuthService, private router: Router, private cityService: WeatherService) { }

  ngOnInit() {
  }

  onCityCreated(city) {
    this.cityService.createCity({
      city: city.value.city
    });
  }

}
