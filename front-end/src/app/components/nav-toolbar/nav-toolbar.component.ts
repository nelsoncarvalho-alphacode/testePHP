import { Component } from '@angular/core';
import { MatToolbarModule } from '@angular/material/toolbar';
import { RouterLink } from '@angular/router';

@Component({
  selector: 'app-nav-toolbar',
  standalone: true,
  imports: [MatToolbarModule, RouterLink],
  templateUrl: './nav-toolbar.component.html',
  styleUrl: './nav-toolbar.component.scss',
})
export class NavToolbarComponent {}
