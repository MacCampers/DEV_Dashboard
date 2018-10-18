import { Component, OnInit, OnChanges, SimpleChanges } from '@angular/core';
import { WheatherService } from '../wheather-service.service';
import { ActivatedRoute, Router } from '@angular/router';

@Component({
  selector: 'app-wheather-city',
  templateUrl: './wheather-city.component.html',
  styleUrls: ['./wheather-city.component.css']
})
export class WheatherCityComponent implements OnInit {

  constructor(private weatherService: WheatherService, private route: ActivatedRoute, private router: Router) { }

  nextCity: string;
  previousCity: string;
  totalCities: number;
  city = '?';
  weather = '?';
  temp = 0;
  failedToLoad: boolean;

  ngOnInit() {
    this.route.paramMap.subscribe(route => {
      this.city = route.get('city');
      this.reset();
      this.weatherService.getCurrentWeather(this.city).subscribe(x => {
        this.weather = x.weather.description;
        this.temp = x.temp;
      },
        error => {
          console.log('error occured', error);
          this.failedToLoad = true;
        });
    });
  }
  
  reset() {
    this.failedToLoad = false;
    this.weather = '?';
    this.temp = 0;
  }

  removeCity() {
    const city = this.nextCity ? this.nextCity : this.previousCity;
    if (city) {
      this.router.navigate(['/city/' + city]);
    } else {
      this.router.navigate(['/add-city/']);
    }
  }

}
