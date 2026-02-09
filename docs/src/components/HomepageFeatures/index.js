import clsx from 'clsx';
import Heading from '@theme/Heading';
import styles from './styles.module.css';

const FeatureList = [
  {
    title: 'Easy to Use',
    Svg: require('@site/static/img/undraw-code-review.svg').default,
    description: (
      <>
        Eloquent UI is designed to be easy to use and customize. No need to write big blobs of boilerplate code just
        to render a textarea or a simple modal, just easy to use blade components.
      </>
    ),
  },
  {
    title: 'Accessible by Design',
    Svg: require('@site/static/img/undraw-web-browsing.svg').default,
    description: (
        <>
            Outputs fully validated and accessible HTML5 code that follow best practices out of the box.
        </>
    ),
  },
  {
    title: 'Full-stack components',
    Svg: require('@site/static/img/undraw-server-cluster.svg').default,
    description: (
      <>
        Eloquent UI comes with a full-stack library for your components. No need to write custom backend code for
        your components, use the provided request helpers, validation rules, model casts, database integrations,
        services and much more.
      </>
    ),
  },
  {
    title: 'Powered by Laravel',
    Svg: require('@site/static/img/undraw-laravel.svg').default,
    description: (
      <>
        Eloquent UI is built on top of Laravel and Bootstrap&nbsp;5. The Blade components can be used in any Laravel
        project.
      </>
    ),
  },
];

function Feature({Svg, title, description}) {
  return (
    <div className={clsx('col col--4')}>
      <div className="text--center">
        <Svg className={styles.featureSvg} role="img" />
      </div>
      <div className="text--center padding-horiz--md">
        <Heading as="h3">{title}</Heading>
        <p>{description}</p>
      </div>
    </div>
  );
}

export default function HomepageFeatures() {
  return (
    <section className={styles.features}>
      <div className="container">
        <div className="row">
          {FeatureList.map((props, idx) => (
            <Feature key={idx} {...props} />
          ))}
        </div>
      </div>
    </section>
  );
}
