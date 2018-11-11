import { Component, OnInit } from '@angular/core';
import { AuthService } from '../authentification/services/auth.service';
import { Router } from '@angular/router';
import { WeatherService } from '../weather/weather-service.service';
import { MapService } from '../map/map-service.service';
import { CalendarService } from '../calendar/service.service';
import { NewsApiService } from '../news/news-api.service';
import { Location } from '@angular/common';
import { YoutubeService } from '../youtube/youtube.service';
import { MovieService } from '../movie/movie.service';
import { TimerService } from '../timer/timer.service';

@Component({
  selector: 'app-dashboard',
  templateUrl: './dashboard.component.html',
  styleUrls: ['./dashboard.component.css']
})
export class DashboardComponent implements OnInit {
  time:number;
  isActiveWeather: number;
  isActiveMap: number;
  isActiveCalendar: number;
  isActiveNews: number;
  isActiveyt: number;
  isActiveMovie: number;

  constructor(public authService: AuthService, private router: Router, private weatherService: WeatherService,
    private mapService: MapService, private calendarService: CalendarService, private newsApiService: NewsApiService,
    private youtubeservice: YoutubeService, private movieService: MovieService, private location: Location,
    private timer: TimerService) { }

  onCityUpdated(city) {
    this.weatherService.updateCity({
      city: city.value.city
    });
  }

  desactivateWeather() {
    this.weatherService.updateIsActive0();
    location.reload();
  }

  desactivateMap() {
    this.mapService.updateIsActive0();
    location.reload();
  }

  desactivateCalendar() {
    this.calendarService.updateIsActive0();
    location.reload();
  }

  desactivateNews() {
    this.newsApiService.updateIsActive0();
    location.reload();
  }

  desactivateYoutube() {
    this.youtubeservice.updateIsActive0();
    location.reload();
  }

  desactivateMovie() {
    this.movieService.updateIsActive0();
    location.reload();
  }


  ngOnInit() {
    this.timer.getTimer().then(x => {
      this.time = x;
      setTimeout(() => {
        window.location.reload();
      }, this.time * 1000);
    })
    this.weatherService.getWeatherDatabase().then(z => {
      this.isActiveWeather = z.isActive;
    })
    this.mapService.getMapDatabase().then(x => {
      this.isActiveMap = x.isActive;
    })
    this.calendarService.getCalendarDatabase().then(x => {
      this.isActiveCalendar = x.isActive;
    })
    this.newsApiService.getNewsDatabase().then(x => {
      this.isActiveNews = x.isActive;
    })
    this.youtubeservice.getYoutubeDatabase().then(x => {
      this.isActiveyt = x.isActive;
    })
    this.movieService.getMovieDatabase().then(z => {
      this.isActiveMovie = z.isActive;
    })
  }
}
