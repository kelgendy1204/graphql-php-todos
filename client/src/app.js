import React, { Component } from 'react';
import Folder from './folder';
import './app.scss';

class App extends Component {
  render() {
    return (
      <div className="app">
          <Folder />
          <Folder />
          <Folder />
          <Folder />
          <Folder />
          <Folder />
          <Folder />
          <Folder />
      </div>
    );
  }
}

export default App;
