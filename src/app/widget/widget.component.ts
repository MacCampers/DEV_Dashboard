import { Component, OnInit, Output, EventEmitter } from '@angular/core';
import { AuthService } from '../authentification/services/auth.service';
import { WeatherService } from '../weather/weather-service.service';
import { MapService } from '../map/map-service.service';
import { CalendarService } from '../calendar/service.service';
import { NewsApiService } from '../news/news-api.service';
import { YoutubeService } from '../youtube/youtube.service';
import { MovieService } from '../movie/movie.service';
import { TimerService } from '../timer/timer.service';
import { FormGroup, FormBuilder, Validators } from '@angular/forms';
import { Location } from '@angular/common';

@Component({
  selector: 'app-widget',
  templateUrl: './widget.component.html',
  styleUrls: ['./widget.component.css']
})
export class WidgetComponent implements OnInit {

  time:number;
  form: FormGroup;

  constructor(private formBuilder: FormBuilder, private timer: TimerService, public authService: AuthService, private weatherService: WeatherService, private mapService: MapService,
    private calendarService: CalendarService, private newsApiService: NewsApiService, private youtubeService: YoutubeService, private movieservice: MovieService, private location: Location) { }

  ngOnInit() {
    this.form = this.formBuilder.group({
      timer: ['', Validators.required]
    })
    this.timer.getTimer().then(x => {
      this.time = x;
    })
  }

  updateTimer() {
    if(this.form.valid) {
      this.timer.updateTimer(this.form.value);
    location.reload();
    }
  }

  activateWeather() {
    this.weatherService.updateIsActive1();
  }

  desactivateWeather() {
    this.weatherService.updateIsActive0();
  }


  activateMap() {
    this.mapService.updateIsActive1();
  }

  desactivateMap() {
    this.mapService.updateIsActive0();
  }

  activateCalendar() {
    this.calendarService.updateIsActive1();
  }

  desactivateCalendar() {
    this.calendarService.updateIsActive0();
  }

  activateNews() {
    this.newsApiService.updateIsActive1();
  }

  desactivateNews() {
    this.newsApiService.updateIsActive0();
  }

  activateYoutube() {
    this.youtubeService.updateIsActive1();
  }

  desactivateYoutube() {
    this.youtubeService.updateIsActive0();
  }

  activateMovie() {
    this.movieservice.updateIsActive1();
  }

  desactivateMovie() {
    this.movieservice.updateIsActive0();
  }
}
