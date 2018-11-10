import { Component, OnInit } from '@angular/core';
import { AuthService } from '../../authentification/services/auth.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-header',
  templateUrl: './header.component.html',
  styleUrls: ['./header.component.css']
})
export class HeaderComponent implements OnInit {

  constructor(public authService:AuthService, private router: Router) { }

  ngOnInit() {
  }

  dashboardPage() {
    this.router.navigate(['/dashboard']);
  }

  settingPage() {
    this.router.navigate(['/userSettings']);
  }
  
  widgetPage() {
    this.router.navigate(['/widget']);
  }

  logoutUser() {
    this.authService.logout();
    this.router.navigate(['/']);
  }
}
