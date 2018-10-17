import { Component, OnInit } from '@angular/core';
import { AuthService } from '../authentification/services/auth.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-widget',
  templateUrl: './widget.component.html',
  styleUrls: ['./widget.component.css']
})
export class WidgetComponent implements OnInit {

  constructor(public authService:AuthService, private router: Router) { }

  ngOnInit() {
  }
  weather() {
    this.router.navigate(['/weather']);
  }

  logoutUser() {
    this.authService.logout();
    this.router.navigate(['/']);
  }

}
