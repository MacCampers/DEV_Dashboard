import { Component, OnInit } from '@angular/core';
import { MovieService } from '../movie.service';
import { FormControl } from '@angular/forms';
import { Router } from '@angular/router';

@Component({
  selector: 'app-movie',
  templateUrl: './movie.component.html',
  styleUrls: ['./movie.component.css']
})

export class MovieComponent implements OnInit {

  results: any[] = [];
  queryField: FormControl = new FormControl();
  constructor(
    private _movies: MovieService,
    private router: Router) {}

   ngOnInit() {
     this._movies.getMovies().subscribe(
       data => {this.results = data.results;
       }
     );
     this.queryField.valueChanges
     .subscribe(queryField => this._movies.search(queryField).subscribe(response => this.results = response.results));
    }

}